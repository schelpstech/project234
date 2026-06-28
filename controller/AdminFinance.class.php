<?php

require_once __DIR__ . '/PaystackPayment.class.php';

class AdminFinance
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->ensureTables();
        new PaystackPayment($db, new Utility());
    }

    public function getSummary(): array
    {
        $stmt = $this->db->query("
            SELECT
                COUNT(*) AS total_invoices,
                COALESCE(SUM(CASE WHEN vetting = 0 THEN 1 ELSE 0 END), 0) AS pending_validation,
                COALESCE(SUM(CASE WHEN vetting = 1 AND invStatus = 0 THEN 1 ELSE 0 END), 0) AS awaiting_payment,
                COALESCE(SUM(CASE WHEN vetting = 1 AND invStatus = 1 THEN 1 ELSE 0 END), 0) AS awaiting_verification,
                COALESCE(SUM(CASE WHEN vetting = 1 AND invStatus = 2 THEN 1 ELSE 0 END), 0) AS paid,
                COALESCE(SUM(CASE WHEN vetting = 1 THEN amountPayable ELSE 0 END), 0) AS validated_amount,
                COALESCE(SUM(CASE WHEN vetting = 1 AND invStatus = 2 THEN amountPayable ELSE 0 END), 0) AS paid_amount
            FROM _tbl_termlyinvoice
        ");

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getTransactions(): array
    {
        $stmt = $this->db->query("
            SELECT
                inv.schCode,
                inv.invReference,
                inv.invType,
                inv.invAmount,
                inv.rebateAmount,
                inv.amountPayable,
                inv.invStatus,
                inv.vetting,
                inv.termRef,
                inv.invRecordTime,
                school.sch_name,
                term.termVariable,
                tx.transactionRef,
                tx.paymentEvidence,
                tx.paymentType,
                tx.submittedOn,
                ps.paystack_reference,
                ps.status AS paystack_status,
                ps.gateway_response,
                ps.verified_at,
                receipt.receipt_number,
                receipt.issued_at,
                receipt.issued_by
            FROM _tbl_termlyinvoice inv
            LEFT JOIN _tbl_sch_corporate_data school
                ON school.sch_code COLLATE utf8mb4_general_ci = inv.schCode COLLATE utf8mb4_general_ci
            LEFT JOIN tblcurrent_term term ON term.id = inv.termRef
            LEFT JOIN (
                SELECT invoiceID,
                    MAX(transactionRef) AS transactionRef,
                    MAX(paymentEvidence) AS paymentEvidence,
                    MAX(paymentType) AS paymentType,
                    MAX(submittedOn) AS submittedOn
                FROM _tbl_transaction
                GROUP BY invoiceID
            ) tx ON tx.invoiceID COLLATE utf8mb4_general_ci = inv.invReference COLLATE utf8mb4_general_ci
            LEFT JOIN crsm_paystack_transactions ps
                ON ps.id = (
                    SELECT MAX(ps2.id)
                    FROM crsm_paystack_transactions ps2
                    WHERE ps2.invoice_reference COLLATE utf8mb4_general_ci = inv.invReference COLLATE utf8mb4_general_ci
                )
            LEFT JOIN crsm_payment_receipts receipt
                ON receipt.invoice_reference COLLATE utf8mb4_general_ci = inv.invReference COLLATE utf8mb4_general_ci
            ORDER BY inv.invRecordTime DESC, inv.invReference DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function confirmUploadedPayment(string $schoolCode, string $invoiceReference, string $adminUser): array
    {
        $schoolCode = $this->safeValue($schoolCode);
        $invoiceReference = $this->safeValue($invoiceReference);
        $invoice = $this->getInvoice($schoolCode, $invoiceReference);

        if (!$invoice) {
            return ['ok' => false, 'message' => 'Invoice was not found.'];
        }

        if ((int) $invoice['vetting'] !== 1 || (int) $invoice['invStatus'] !== 1) {
            return ['ok' => false, 'message' => 'Only validated invoices awaiting payment confirmation can be confirmed.'];
        }

        if (!$this->hasUploadedTransaction($invoiceReference)) {
            return ['ok' => false, 'message' => 'No uploaded payment evidence was found for this invoice.'];
        }

        $this->db->beginTransaction();
        try {
            $this->markInvoicePaid($schoolCode, $invoiceReference);
            $receipt = $this->issueReceipt($invoice, $adminUser);
            $this->db->commit();

            return ['ok' => true, 'message' => 'Payment confirmed and receipt issued.', 'receipt_number' => $receipt['receipt_number']];
        } catch (Throwable $e) {
            $this->db->rollBack();
            error_log('Manual payment confirmation failed: ' . $e->getMessage());
            return ['ok' => false, 'message' => 'Unable to confirm payment. Check the server log.'];
        }
    }

    public function rejectUploadedPayment(string $schoolCode, string $invoiceReference, string $adminUser): array
    {
        $schoolCode = $this->safeValue($schoolCode);
        $invoiceReference = $this->safeValue($invoiceReference);

        $stmt = $this->db->prepare("
            UPDATE _tbl_termlyinvoice
            SET invStatus = 0
            WHERE schCode = ? AND invReference = ? AND invStatus = 1 AND vetting = 1
        ");
        $stmt->execute([$schoolCode, $invoiceReference]);

        return [
            'ok' => $stmt->rowCount() === 1,
            'message' => $stmt->rowCount() === 1
                ? 'Payment evidence rejected. The invoice is open for another payment submission.'
                : 'Payment evidence could not be rejected.',
        ];
    }

    public function issueReceiptForInvoice(string $invoiceReference, string $adminUser): array
    {
        $invoiceReference = $this->safeValue($invoiceReference);
        $invoice = $this->getInvoiceByReference($invoiceReference);

        if (!$invoice) {
            return ['ok' => false, 'message' => 'Invoice was not found.'];
        }

        if ((int) $invoice['invStatus'] !== 2) {
            return ['ok' => false, 'message' => 'Receipt can only be issued for confirmed payments.'];
        }

        $receipt = $this->issueReceipt($invoice, $adminUser);
        return ['ok' => true, 'message' => 'Receipt issued.', 'receipt_number' => $receipt['receipt_number']];
    }

    public function issueReceiptForPaystackReference(string $paystackReference, string $adminUser): array
    {
        $paystackReference = $this->safeValue($paystackReference);
        $stmt = $this->db->prepare('SELECT invoice_reference FROM crsm_paystack_transactions WHERE paystack_reference = ? LIMIT 1');
        $stmt->execute([$paystackReference]);
        $invoiceReference = (string) $stmt->fetchColumn();

        if ($invoiceReference === '') {
            return ['ok' => false, 'message' => 'Paystack transaction was not found.'];
        }

        return $this->issueReceiptForInvoice($invoiceReference, $adminUser);
    }

    public function getReceipt(string $receiptNumber): ?array
    {
        $receiptNumber = $this->safeValue($receiptNumber);
        $stmt = $this->db->prepare("
            SELECT receipt.*,
                inv.invType,
                inv.invAmount,
                inv.rebateAmount,
                inv.amountPayable,
                inv.invRecordTime,
                school.sch_name,
                term.termVariable
            FROM crsm_payment_receipts receipt
            LEFT JOIN _tbl_termlyinvoice inv
                ON inv.invReference COLLATE utf8mb4_general_ci = receipt.invoice_reference COLLATE utf8mb4_general_ci
            LEFT JOIN _tbl_sch_corporate_data school
                ON school.sch_code COLLATE utf8mb4_general_ci = receipt.sch_code COLLATE utf8mb4_general_ci
            LEFT JOIN tblcurrent_term term ON term.id = inv.termRef
            WHERE receipt.receipt_number = ?
            LIMIT 1
        ");
        $stmt->execute([$receiptNumber]);
        $receipt = $stmt->fetch(PDO::FETCH_ASSOC);

        return $receipt ?: null;
    }

    public function getReceiptByInvoice(string $invoiceReference): ?array
    {
        $invoiceReference = $this->safeValue($invoiceReference);
        $stmt = $this->db->prepare('SELECT * FROM crsm_payment_receipts WHERE invoice_reference = ? LIMIT 1');
        $stmt->execute([$invoiceReference]);
        $receipt = $stmt->fetch(PDO::FETCH_ASSOC);

        return $receipt ?: null;
    }

    private function ensureTables(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS crsm_payment_receipts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                receipt_number VARCHAR(80) NOT NULL UNIQUE,
                invoice_reference VARCHAR(80) NOT NULL UNIQUE,
                sch_code VARCHAR(50) NOT NULL,
                amount_paid DECIMAL(14,2) NOT NULL,
                payment_method VARCHAR(40) NULL,
                issued_by VARCHAR(120) NULL,
                issued_at DATETIME NOT NULL,
                created_at DATETIME NOT NULL,
                INDEX idx_receipt_school (sch_code),
                INDEX idx_receipt_invoice (invoice_reference)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        $this->normalizeCollation('crsm_payment_receipts');
    }

    private function normalizeCollation(string $table): void
    {
        try {
            $stmt = $this->db->prepare("
                SELECT TABLE_COLLATION
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?
                LIMIT 1
            ");
            $stmt->execute([$table]);
            if ((string) $stmt->fetchColumn() !== 'utf8mb4_general_ci') {
                $this->db->exec("ALTER TABLE {$table} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
            }
        } catch (Throwable $e) {
            error_log('Finance collation normalization failed for ' . $table . ': ' . $e->getMessage());
        }
    }

    private function getInvoice(string $schoolCode, string $invoiceReference): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM _tbl_termlyinvoice WHERE schCode = ? AND invReference = ? LIMIT 1');
        $stmt->execute([$schoolCode, $invoiceReference]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        return $invoice ?: null;
    }

    private function getInvoiceByReference(string $invoiceReference): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM _tbl_termlyinvoice WHERE invReference = ? LIMIT 1');
        $stmt->execute([$invoiceReference]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        return $invoice ?: null;
    }

    private function hasUploadedTransaction(string $invoiceReference): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM _tbl_transaction
            WHERE invoiceID = ?
                AND paymentType <> 'paystack'
        ");
        $stmt->execute([$invoiceReference]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function markInvoicePaid(string $schoolCode, string $invoiceReference): void
    {
        $stmt = $this->db->prepare("
            UPDATE _tbl_termlyinvoice
            SET invStatus = 2
            WHERE schCode = ? AND invReference = ? AND vetting = 1
        ");
        $stmt->execute([$schoolCode, $invoiceReference]);
    }

    private function issueReceipt(array $invoice, string $adminUser): array
    {
        $existing = $this->db->prepare('SELECT * FROM crsm_payment_receipts WHERE invoice_reference = ? LIMIT 1');
        $existing->execute([$invoice['invReference']]);
        $receipt = $existing->fetch(PDO::FETCH_ASSOC);

        if ($receipt) {
            return $receipt;
        }

        $paymentMethod = $this->paymentMethodForInvoice($invoice['invReference']);
        $receiptNumber = $this->generateReceiptNumber();
        $stmt = $this->db->prepare("
            INSERT INTO crsm_payment_receipts
                (receipt_number, invoice_reference, sch_code, amount_paid, payment_method, issued_by, issued_at, created_at)
            VALUES
                (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([
            $receiptNumber,
            $invoice['invReference'],
            $invoice['schCode'],
            (float) $invoice['amountPayable'],
            $paymentMethod,
            $adminUser,
        ]);

        return $this->getReceipt($receiptNumber) ?: ['receipt_number' => $receiptNumber];
    }

    private function paymentMethodForInvoice(string $invoiceReference): string
    {
        $stmt = $this->db->prepare('SELECT paymentType FROM _tbl_transaction WHERE invoiceID = ? ORDER BY submittedOn DESC LIMIT 1');
        $stmt->execute([$invoiceReference]);
        $method = (string) $stmt->fetchColumn();

        return $method !== '' ? $method : 'manual';
    }

    private function generateReceiptNumber(): string
    {
        for ($i = 0; $i < 5; $i++) {
            $receiptNumber = 'CRSM-RCPT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM crsm_payment_receipts WHERE receipt_number = ?');
            $stmt->execute([$receiptNumber]);
            if ((int) $stmt->fetchColumn() === 0) {
                return $receiptNumber;
            }
        }

        return 'CRSM-RCPT-' . date('YmdHis') . '-' . random_int(100, 999);
    }

    private function safeValue(string $value): string
    {
        return preg_replace('/[^A-Za-z0-9_.@-]/', '', trim($value));
    }
}

?>
