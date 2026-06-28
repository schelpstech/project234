<?php

class PaystackPayment
{
    private PDO $db;
    private Utility $utility;
    private string $baseUrl;

    public function __construct(PDO $db, Utility $utility, ?string $baseUrl = null, bool $ensureTables = true)
    {
        $this->db = $db;
        $this->utility = $utility;
        $this->baseUrl = rtrim($baseUrl ?: $this->detectBaseUrl(), '/');

        if ($ensureTables) {
            $this->ensureTables();
        }
    }

    public function initializeInvoicePayment(string $schoolCode, string $invoiceReference): array
    {
        $schoolCode = $this->safeValue($schoolCode);
        $invoiceReference = $this->safeValue($invoiceReference);
        $secretKey = $this->secretKey();

        if ($secretKey === '') {
            return ['ok' => false, 'message' => 'Paystack secret key is not configured.', 'authorization_url' => null];
        }

        $invoice = $this->getInvoice($schoolCode, $invoiceReference);
        if (!$invoice) {
            return ['ok' => false, 'message' => 'Invoice could not be verified for online payment.', 'authorization_url' => null];
        }

        if ((int) $invoice['vetting'] !== 1) {
            return ['ok' => false, 'message' => 'This invoice must be validated before online payment.', 'authorization_url' => null];
        }

        if ((int) $invoice['invStatus'] === 2) {
            return ['ok' => false, 'message' => 'This invoice has already been paid.', 'authorization_url' => null];
        }

        $amount = (float) $invoice['amountPayable'];
        if ($amount <= 0) {
            return ['ok' => false, 'message' => 'Invoice amount is invalid for online payment.', 'authorization_url' => null];
        }

        $email = $this->schoolEmail($schoolCode);
        if (!$email) {
            return ['ok' => false, 'message' => 'This school needs a valid email address before online payment can start.', 'authorization_url' => null];
        }

        $amountKobo = (int) round($amount * 100);
        $reference = $this->generateReference($schoolCode, $invoiceReference);
        $callbackUrl = getenv('PAYSTACK_CALLBACK_URL') ?: $this->baseUrl . '/app/paystackCallback.php';

        $this->createTransaction($schoolCode, $invoiceReference, $reference, $amountKobo);

        $payload = [
            'email' => $email,
            'amount' => $amountKobo,
            'reference' => $reference,
            'callback_url' => $callbackUrl,
            'metadata' => [
                'school_code' => $schoolCode,
                'school_name' => $invoice['sch_name'] ?? '',
                'invoice_reference' => $invoiceReference,
                'invoice_type' => $invoice['invType'] ?? '',
            ],
        ];

        $response = $this->request('POST', 'https://api.paystack.co/transaction/initialize', $payload, $secretKey);

        if (!$response['ok'] || empty($response['body']['status']) || empty($response['body']['data']['authorization_url'])) {
            $this->markTransaction($reference, 'failed', $response['message'], $response['body'] ?? []);
            return ['ok' => false, 'message' => $response['message'], 'authorization_url' => null];
        }

        $data = $response['body']['data'];
        $this->markInitialized($reference, $data['access_code'] ?? '', $data['authorization_url'], $response['body']);

        return [
            'ok' => true,
            'message' => 'Online payment initialized.',
            'authorization_url' => $data['authorization_url'],
            'reference' => $reference,
        ];
    }

    public function verifyReference(string $reference): array
    {
        $reference = $this->safeReference($reference);
        $secretKey = $this->secretKey();

        if ($reference === '' || $secretKey === '') {
            return ['ok' => false, 'message' => 'Payment reference or Paystack configuration is missing.'];
        }

        $transaction = $this->getTransaction($reference);
        if (!$transaction) {
            return ['ok' => false, 'message' => 'Payment reference was not found on this portal.'];
        }

        $response = $this->request('GET', 'https://api.paystack.co/transaction/verify/' . rawurlencode($reference), null, $secretKey);
        if (!$response['ok'] || empty($response['body']['status'])) {
            $this->markTransaction($reference, 'verification_failed', $response['message'], $response['body'] ?? []);
            return ['ok' => false, 'message' => $response['message']];
        }

        $data = $response['body']['data'] ?? [];
        $gatewayStatus = (string) ($data['status'] ?? '');
        $gatewayResponse = (string) ($data['gateway_response'] ?? '');

        if ($gatewayStatus !== 'success') {
            $this->markTransaction($reference, $gatewayStatus ?: 'not_successful', $gatewayResponse ?: 'Payment was not successful.', $response['body']);
            return ['ok' => false, 'message' => $gatewayResponse ?: 'Payment was not successful.'];
        }

        if ((int) ($data['amount'] ?? 0) !== (int) $transaction['amount_kobo']) {
            $this->markTransaction($reference, 'amount_mismatch', 'Verified amount does not match the invoice amount.', $response['body']);
            return ['ok' => false, 'message' => 'Verified amount does not match the invoice amount.'];
        }

        $invoice = $this->getInvoice($transaction['sch_code'], $transaction['invoice_reference']);
        if (!$invoice) {
            $this->markTransaction($reference, 'invoice_missing', 'Invoice was not found during verification.', $response['body']);
            return ['ok' => false, 'message' => 'Invoice was not found during verification.'];
        }

        $this->db->beginTransaction();
        try {
            $this->markInvoicePaid($transaction['sch_code'], $transaction['invoice_reference']);
            $this->recordPortalTransaction($transaction['sch_code'], $transaction['invoice_reference'], $reference);
            $this->markVerified($reference, $gatewayResponse, $data['paid_at'] ?? null, $response['body']);
            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack();
            error_log('Paystack payment finalization failed: ' . $e->getMessage());
            return ['ok' => false, 'message' => 'Payment was verified, but the portal could not finalize the invoice. Contact support.'];
        }

        return ['ok' => true, 'message' => 'Payment verified and invoice confirmed.'];
    }

    private function ensureTables(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS crsm_paystack_transactions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                sch_code VARCHAR(50) NOT NULL,
                invoice_reference VARCHAR(80) NOT NULL,
                paystack_reference VARCHAR(120) NOT NULL UNIQUE,
                access_code VARCHAR(120) NULL,
                authorization_url TEXT NULL,
                amount_kobo BIGINT NOT NULL,
                currency VARCHAR(8) NOT NULL DEFAULT 'NGN',
                status VARCHAR(40) NOT NULL DEFAULT 'initialized',
                gateway_response VARCHAR(255) NULL,
                payload_json MEDIUMTEXT NULL,
                verified_at DATETIME NULL,
                paid_at DATETIME NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX idx_paystack_invoice (invoice_reference),
                INDEX idx_paystack_school (sch_code),
                INDEX idx_paystack_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        $this->normalizeCollation('crsm_paystack_transactions');
    }

    private function getInvoice(string $schoolCode, string $invoiceReference): ?array
    {
        $stmt = $this->db->prepare("
            SELECT inv.*, scd.sch_name, term.termVariable
            FROM _tbl_termlyinvoice inv
            LEFT JOIN _tbl_sch_corporate_data scd
                ON scd.sch_code COLLATE utf8mb4_general_ci = inv.schCode COLLATE utf8mb4_general_ci
            LEFT JOIN tblcurrent_term term ON term.id = inv.termRef
            WHERE inv.schCode = ? AND inv.invReference = ?
            LIMIT 1
        ");
        $stmt->execute([$schoolCode, $invoiceReference]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        return $invoice ?: null;
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
            error_log('Paystack collation normalization failed for ' . $table . ': ' . $e->getMessage());
        }
    }

    private function schoolEmail(string $schoolCode): ?string
    {
        $stmt = $this->db->prepare("
            SELECT email FROM tbl_sch_portal_admin
            WHERE schCode = ? AND email <> ''
            LIMIT 1
        ");
        $stmt->execute([$schoolCode]);
        $email = $stmt->fetchColumn();

        if (!$email) {
            $stmt = $this->db->prepare("
                SELECT email_addrs FROM _tbl_email_address
                WHERE sch_code = ? AND email_addrs <> ''
                LIMIT 1
            ");
            $stmt->execute([$schoolCode]);
            $email = $stmt->fetchColumn();
        }

        $valid = filter_var((string) $email, FILTER_VALIDATE_EMAIL);
        return $valid ?: null;
    }

    private function createTransaction(string $schoolCode, string $invoiceReference, string $reference, int $amountKobo): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO crsm_paystack_transactions
                (sch_code, invoice_reference, paystack_reference, amount_kobo, status, created_at, updated_at)
            VALUES
                (?, ?, ?, ?, 'initialized', NOW(), NOW())
        ");
        $stmt->execute([$schoolCode, $invoiceReference, $reference, $amountKobo]);
    }

    private function markInitialized(string $reference, string $accessCode, string $authorizationUrl, array $payload): void
    {
        $stmt = $this->db->prepare("
            UPDATE crsm_paystack_transactions
            SET access_code = ?,
                authorization_url = ?,
                status = 'authorization_ready',
                payload_json = ?,
                updated_at = NOW()
            WHERE paystack_reference = ?
        ");
        $stmt->execute([$accessCode, $authorizationUrl, json_encode($payload, JSON_UNESCAPED_SLASHES), $reference]);
    }

    private function markTransaction(string $reference, string $status, string $message, array $payload): void
    {
        $stmt = $this->db->prepare("
            UPDATE crsm_paystack_transactions
            SET status = ?,
                gateway_response = ?,
                payload_json = ?,
                updated_at = NOW()
            WHERE paystack_reference = ?
        ");
        $stmt->execute([$status, $message, json_encode($payload, JSON_UNESCAPED_SLASHES), $reference]);
    }

    private function markVerified(string $reference, string $gatewayResponse, ?string $paidAt, array $payload): void
    {
        $paidAtValue = null;
        if ($paidAt) {
            $timestamp = strtotime($paidAt);
            if ($timestamp !== false) {
                $paidAtValue = date('Y-m-d H:i:s', $timestamp);
            }
        }

        $stmt = $this->db->prepare("
            UPDATE crsm_paystack_transactions
            SET status = 'success',
                gateway_response = ?,
                payload_json = ?,
                verified_at = NOW(),
                paid_at = ?,
                updated_at = NOW()
            WHERE paystack_reference = ?
        ");
        $stmt->execute([$gatewayResponse, json_encode($payload, JSON_UNESCAPED_SLASHES), $paidAtValue, $reference]);
    }

    private function getTransaction(string $reference): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM crsm_paystack_transactions WHERE paystack_reference = ? LIMIT 1');
        $stmt->execute([$reference]);
        $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

        return $transaction ?: null;
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

    private function recordPortalTransaction(string $schoolCode, string $invoiceReference, string $paystackReference): void
    {
        $exists = $this->db->prepare("
            SELECT COUNT(*) FROM _tbl_transaction
            WHERE invoiceID = ? AND paymentType = 'paystack'
        ");
        $exists->execute([$invoiceReference]);
        if ((int) $exists->fetchColumn() > 0) {
            return;
        }

        $stmt = $this->db->prepare("
            INSERT INTO _tbl_transaction
                (transactionRef, schCode, invoiceID, paymentEvidence, paymentType, submittedOn)
            VALUES
                (?, ?, ?, ?, 'paystack', ?)
        ");
        $stmt->execute([
            $this->generatePortalTransactionRef(),
            $schoolCode,
            $invoiceReference,
            'Paystack online payment: ' . $paystackReference,
            date('Y-m-d'),
        ]);
    }

    private function request(string $method, string $url, ?array $payload, string $secretKey): array
    {
        if (!function_exists('curl_init')) {
            return ['ok' => false, 'message' => 'PHP cURL extension is required for Paystack payments.', 'body' => []];
        }

        $ch = curl_init($url);
        $headers = [
            'Authorization: Bearer ' . $secretKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 45,
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
        }

        $raw = curl_exec($ch);
        $error = curl_error($ch);
        $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false) {
            return ['ok' => false, 'message' => $error ?: 'Unable to connect to Paystack.', 'body' => []];
        }

        $body = json_decode($raw, true);
        if (!is_array($body)) {
            return ['ok' => false, 'message' => 'Invalid response from Paystack.', 'body' => []];
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            return ['ok' => false, 'message' => (string) ($body['message'] ?? 'Paystack request failed.'), 'body' => $body];
        }

        return ['ok' => true, 'message' => (string) ($body['message'] ?? 'Paystack request successful.'), 'body' => $body];
    }

    private function secretKey(): string
    {
        return trim((string) getenv('PAYSTACK_SECRET_KEY'));
    }

    private function generateReference(string $schoolCode, string $invoiceReference): string
    {
        return 'CRSM-' . $schoolCode . '-' . $invoiceReference . '-' . date('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(3)));
    }

    private function generatePortalTransactionRef(): string
    {
        for ($i = 0; $i < 5; $i++) {
            $reference = (string) random_int(1000000000, 9999999999);
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM _tbl_transaction WHERE transactionRef = ?');
            $stmt->execute([$reference]);
            if ((int) $stmt->fetchColumn() === 0) {
                return $reference;
            }
        }

        return (string) random_int(1000000000, 9999999999);
    }

    private function detectBaseUrl(): string
    {
        $envUrl = getenv('CRSM_PORTAL_URL');
        if ($envUrl) {
            return $envUrl;
        }

        if (!empty($_SERVER['HTTP_HOST'])) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $root = preg_replace('#/app/.*$|/pages/.*$|/login/.*$#', '', $scriptName);
            return $scheme . '://' . $_SERVER['HTTP_HOST'] . $root;
        }

        return 'http://localhost/project234';
    }

    private function safeValue(string $value): string
    {
        return preg_replace('/[^A-Za-z0-9_.@-]/', '', trim($value));
    }

    private function safeReference(string $value): string
    {
        return preg_replace('/[^A-Za-z0-9_.@-]/', '', trim($value));
    }
}

?>
