<?php

use PHPMailer\PHPMailer\PHPMailer;

class ComplianceMailer
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

    public function queueWeeklyCampaign(string $createdBy = 'system'): array
    {
        $term = $this->getActiveTerm();
        $campaignKey = 'portal-compliance-' . date('o-\WW');
        $subject = 'Urgent Action Required: CRSM Portal Update, Enrolment and 2% Remittance Status';

        if (!$this->acquireLock('crsm_compliance_mail_queue', 1)) {
            return [
                'campaign_id' => 0,
                'campaign_key' => $campaignKey,
                'queued' => 0,
                'updated' => 0,
                'skipped_no_email' => 0,
                'message' => 'The weekly queue is already being prepared.',
            ];
        }

        try {
            $campaignId = $this->getOrCreateCampaign($campaignKey, 'Weekly CRSM Portal Compliance Notice', $subject, $createdBy);
            if ($campaignId < 1) {
                throw new RuntimeException('Unable to create or load the weekly compliance campaign.');
            }

            $queued = 0;
            $updated = 0;
            $skippedNoEmail = 0;

            foreach ($this->getSchoolStatuses() as $status) {
                $recipient = $this->selectRecipientEmail($status);
                $existing = $this->getQueueForSchool($campaignId, $status['sch_code']);

                if (!$recipient) {
                    if (!$existing) {
                        $this->insertQueueRow($campaignId, $status, null, $subject, '', '', 'skipped_no_email');
                    }
                    $skippedNoEmail++;
                    continue;
                }

                $token = $existing['tracking_token'] ?? bin2hex(random_bytes(24));
                $payload = $this->buildMailPayload($status, $term, $token);

                if ($existing) {
                    if (in_array($existing['status'], ['queued', 'failed', 'skipped_no_email'], true)) {
                        $this->updateQueueRow((int) $existing['id'], $recipient, $subject, $payload, 'queued');
                        $updated++;
                    }
                    continue;
                }

                $this->insertQueueRow($campaignId, $status, $recipient, $subject, $payload['html'], $payload['text'], 'queued', $token, $payload['payload']);
                $queued++;
            }

            $this->refreshCampaignCounts($campaignId);

            return [
                'campaign_id' => $campaignId,
                'campaign_key' => $campaignKey,
                'queued' => $queued,
                'updated' => $updated,
                'skipped_no_email' => $skippedNoEmail,
                'message' => 'Queue prepared.',
            ];
        } finally {
            $this->releaseLock('crsm_compliance_mail_queue');
        }
    }

    public function sendQueued(int $limit = 45): array
    {
        $limit = max(1, min(50, $limit));
        if (!$this->acquireLock('crsm_compliance_mail_send', 1)) {
            return [
                'sent' => 0,
                'failed' => 0,
                'remaining_hourly_allowance' => 0,
                'message' => 'The mail queue is already being processed.',
            ];
        }

        try {
            $this->releaseStaleSendingItems();
            $sentLastHour = $this->countSentLastHour();
            $remainingHourlyAllowance = max(0, 50 - $sentLastHour);
            $sendLimit = min($limit, $remainingHourlyAllowance);

            if ($sendLimit < 1) {
                return [
                    'sent' => 0,
                    'failed' => 0,
                    'remaining_hourly_allowance' => 0,
                    'message' => 'Hourly mail limit reached. Try again later.',
                ];
            }

            $items = $this->getQueuedItems($sendLimit);
            $sent = 0;
            $failed = 0;

            foreach ($items as $item) {
                if (!$this->markSending((int) $item['id'])) {
                    continue;
                }

                $result = $this->sendQueueItem($item);

                if ($result['ok']) {
                    $this->markSent((int) $item['id'], $result['transaction_id']);
                    $sent++;
                } else {
                    $this->markFailed((int) $item['id'], (int) $item['attempts'] + 1, $result['error']);
                    $failed++;
                }
            }

            return [
                'sent' => $sent,
                'failed' => $failed,
                'remaining_hourly_allowance' => max(0, $remainingHourlyAllowance - $sent),
                'message' => 'Queue processed.',
            ];
        } finally {
            $this->releaseLock('crsm_compliance_mail_send');
        }
    }

    public function addSchoolEmail(string $schoolCode, string $email, string $adminUser): bool
    {
        $schoolCode = $this->safeRouteValue($schoolCode);
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        if (!$schoolCode || !$email) {
            return false;
        }

        $exists = $this->db->prepare('SELECT id FROM _tbl_email_address WHERE sch_code = ? AND email_addrs = ? LIMIT 1');
        $exists->execute([$schoolCode, $email]);

        if ($exists->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }

        $stmt = $this->db->prepare('INSERT INTO _tbl_email_address (sch_code, email_addrs, vetted) VALUES (?, ?, 1)');
        return $stmt->execute([$schoolCode, $email]);
    }

    public function markOpened(string $trackingToken): bool
    {
        if (!preg_match('/^[A-Fa-f0-9]{48}$/', $trackingToken)) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE crsm_mail_queue
            SET open_count = open_count + 1,
                opened_at = COALESCE(opened_at, NOW()),
                status = CASE WHEN status = 'sent' THEN 'opened' ELSE status END,
                updated_at = NOW()
            WHERE tracking_token = ?
        ");

        return $stmt->execute([$trackingToken]);
    }

    public function getCampaigns(int $limit = 20): array
    {
        $stmt = $this->db->prepare('SELECT * FROM crsm_mail_campaigns ORDER BY created_at DESC LIMIT ' . max(1, (int) $limit));
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQueueReport(int $limit = 250): array
    {
        $stmt = $this->db->prepare("
            SELECT q.*, c.campaign_key, c.title
            FROM crsm_mail_queue q
            LEFT JOIN crsm_mail_campaigns c ON c.id = q.campaign_id
            ORDER BY q.queued_at DESC, q.id DESC
            LIMIT " . max(1, (int) $limit)
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQueueSummary(): array
    {
        $stmt = $this->db->query("
            SELECT status, COUNT(*) AS total
            FROM crsm_mail_queue
            GROUP BY status
        ");

        $summary = [
            'queued' => 0,
            'sending' => 0,
            'sent' => 0,
            'opened' => 0,
            'failed' => 0,
            'skipped_no_email' => 0,
        ];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $summary[$row['status']] = (int) $row['total'];
        }

        return $summary;
    }

    public function getSchoolsWithoutEmail(): array
    {
        $stmt = $this->db->query("
            SELECT scd.sch_code, scd.sch_name
            FROM _tbl_sch_corporate_data scd
            LEFT JOIN _tbl_email_address ea ON ea.sch_code = scd.sch_code AND ea.email_addrs <> ''
            LEFT JOIN tbl_sch_portal_admin spa ON spa.schCode = scd.sch_code AND spa.email <> ''
            WHERE ea.id IS NULL AND spa.schCode IS NULL
            ORDER BY scd.sch_name ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSchoolStatuses(): array
    {
        $term = $this->getActiveTerm();
        $termId = (int) ($term['id'] ?? 0);

        $stmt = $this->db->prepare("
            SELECT
                scd.sch_code,
                scd.sch_name,
                scd.schLogo,
                scd.sch_type_gender,
                scd.sch_type_accom,
                scd.date_established,
                scd.available_classes,
                COALESCE(phone.phone_count, 0) AS phone_count,
                COALESCE(email.email_count, 0) AS email_count,
                email.contact_emails,
                portal_admin.portal_admin_email,
                COALESCE(addresses.address_count, 0) AS address_count,
                COALESCE(approvals.approval_count, 0) AS approval_count,
                COALESCE(facilities.facility_count, 0) AS facility_count,
                COALESCE(classes.class_count, 0) AS class_count,
                COALESCE(personnel.teacher_count, 0) AS teacher_count,
                COALESCE(logins.login_count, 0) AS login_count,
                logins.last_login,
                COALESCE(enrolment.active_enrolment_count, 0) AS active_enrolment_count,
                COALESCE(enrolment.active_population, 0) AS active_population,
                COALESCE(enrolment.active_remittance_due, 0) AS active_remittance_due,
                COALESCE(active_invoice.active_invoice_count, 0) AS active_invoice_count,
                COALESCE(remittance.confirmed_remittance, 0) AS confirmed_remittance,
                COALESCE(remittance.awaiting_confirmation_remittance, 0) AS awaiting_confirmation_remittance,
                COALESCE(remittance.unpaid_remittance, 0) AS unpaid_remittance
            FROM _tbl_sch_corporate_data scd
            LEFT JOIN (
                SELECT sch_code, COUNT(*) AS phone_count
                FROM _tbl_phone_number
                GROUP BY sch_code
            ) phone ON phone.sch_code = scd.sch_code
            LEFT JOIN (
                SELECT sch_code, COUNT(*) AS email_count, GROUP_CONCAT(email_addrs SEPARATOR ', ') AS contact_emails
                FROM _tbl_email_address
                WHERE email_addrs <> ''
                GROUP BY sch_code
            ) email ON email.sch_code = scd.sch_code
            LEFT JOIN (
                SELECT schCode, MIN(email) AS portal_admin_email
                FROM tbl_sch_portal_admin
                WHERE email <> ''
                GROUP BY schCode
            ) portal_admin ON portal_admin.schCode = scd.sch_code
            LEFT JOIN (
                SELECT sch_code, COUNT(*) AS address_count
                FROM _tbl_sch_address
                GROUP BY sch_code
            ) addresses ON addresses.sch_code = scd.sch_code
            LEFT JOIN (
                SELECT sch_code, COUNT(*) AS approval_count
                FROM _tbl_approval_record
                GROUP BY sch_code
            ) approvals ON approvals.sch_code = scd.sch_code
            LEFT JOIN (
                SELECT sch_code, COUNT(*) AS facility_count
                FROM _sch_facility_record
                GROUP BY sch_code
            ) facilities ON facilities.sch_code = scd.sch_code
            LEFT JOIN (
                SELECT schCode, COUNT(*) AS class_count
                FROM tbl_classes
                GROUP BY schCode
            ) classes ON classes.schCode = scd.sch_code
            LEFT JOIN (
                SELECT schCode, COUNT(*) AS teacher_count
                FROM tbl_personnel_record
                GROUP BY schCode
            ) personnel ON personnel.schCode = scd.sch_code
            LEFT JOIN (
                SELECT user_name, COUNT(*) AS login_count, MAX(rectime) AS last_login
                FROM log
                WHERE activity LIKE '%Login%'
                GROUP BY user_name
            ) logins ON logins.user_name = scd.sch_code
            LEFT JOIN (
                SELECT schCode,
                    COUNT(*) AS active_enrolment_count,
                    COALESCE(SUM(population), 0) AS active_population,
                    COALESCE(SUM(population * tuition * 0.02), 0) AS active_remittance_due
                FROM _tbl_termly_enrolment
                WHERE termID = ?
                GROUP BY schCode
            ) enrolment ON enrolment.schCode = scd.sch_code
            LEFT JOIN (
                SELECT schCode, COUNT(*) AS active_invoice_count
                FROM _tbl_termlyinvoice
                WHERE termRef = ? AND invType = 'Termly Remittance'
                GROUP BY schCode
            ) active_invoice ON active_invoice.schCode = scd.sch_code
            LEFT JOIN (
                SELECT schCode,
                    COALESCE(SUM(CASE WHEN invStatus = 2 THEN amountPayable ELSE 0 END), 0) AS confirmed_remittance,
                    COALESCE(SUM(CASE WHEN invStatus = 1 THEN amountPayable ELSE 0 END), 0) AS awaiting_confirmation_remittance,
                    COALESCE(SUM(CASE WHEN invStatus = 0 THEN amountPayable ELSE 0 END), 0) AS unpaid_remittance
                FROM _tbl_termlyinvoice
                WHERE invType = 'Termly Remittance'
                GROUP BY schCode
            ) remittance ON remittance.schCode = scd.sch_code
            ORDER BY scd.sch_name ASC
        ");
        $stmt->execute([$termId, $termId]);
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($statuses as &$status) {
            $classStatus = $this->getClassStatus($status['sch_code'], $termId);
            $status['classes_created'] = $classStatus['classes_created'];
            $status['missing_classes'] = $classStatus['missing_classes'];
            $status['enrolment_records'] = $classStatus['enrolment_records'];
            $status['deficits'] = $this->buildDeficits($status);
            $status['recipient_email'] = $this->selectRecipientEmail($status);
        }
        unset($status);

        return $statuses;
    }

    private function getClassStatus(string $schoolCode, int $termId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                c.id,
                c.className,
                c.classArm,
                MAX(te.recordid) AS recordid,
                COALESCE(MAX(te.population), 0) AS population,
                COALESCE(MAX(te.tuition), 0) AS tuition
            FROM tbl_classes c
            LEFT JOIN _tbl_termly_enrolment te
                ON te.classID = c.id
                AND te.schCode = c.schCode
                AND te.termID = ?
            WHERE c.schCode = ?
            GROUP BY c.id, c.className, c.classArm
            ORDER BY c.className ASC
        ");
        $stmt->execute([$termId, $schoolCode]);

        $classes = [];
        $missing = [];
        $records = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $label = trim($row['className'] . (!empty($row['classArm']) ? ' ' . $row['classArm'] : ''));
            $classes[] = $label;

            if (empty($row['recordid'])) {
                $missing[] = $label;
            } else {
                $records[] = [
                    'class' => $label,
                    'population' => (int) $row['population'],
                    'tuition' => (float) $row['tuition'],
                    'remittance_due' => ((float) $row['population'] * (float) $row['tuition']) * 0.02,
                ];
            }
        }

        return [
            'classes_created' => $classes,
            'missing_classes' => $missing,
            'enrolment_records' => $records,
        ];
    }

    private function buildDeficits(array $status): array
    {
        $deficits = [];

        if (empty($status['schLogo']) || empty($status['sch_type_gender']) || empty($status['sch_type_accom']) || empty($status['date_established']) || empty($status['available_classes'])) {
            $deficits[] = 'Corporate profile is incomplete.';
        }
        if ((int) $status['phone_count'] < 1) {
            $deficits[] = 'No phone contact has been submitted.';
        }
        if ((int) $status['email_count'] < 1 && empty($status['portal_admin_email'])) {
            $deficits[] = 'No valid email address is on the portal.';
        }
        if ((int) $status['address_count'] < 1) {
            $deficits[] = 'Physical address is missing.';
        }
        if ((int) $status['class_count'] < 1) {
            $deficits[] = 'No class has been created.';
        }
        if ((int) $status['teacher_count'] < 1) {
            $deficits[] = 'No teacher/personnel record has been created.';
        }
        if ((int) $status['approval_count'] < 1) {
            $deficits[] = 'Approval record is missing.';
        }
        if ((int) $status['facility_count'] < 1) {
            $deficits[] = 'Facility record is missing.';
        }
        if (!empty($status['classes_created']) && !empty($status['missing_classes'])) {
            $deficits[] = 'Active-term enrolment is missing for ' . count($status['missing_classes']) . ' class(es).';
        }
        if (!empty($status['classes_created']) && (int) $status['active_invoice_count'] < 1) {
            $deficits[] = '2% remittance invoice has not been generated for the active term.';
        } elseif ((float) $status['unpaid_remittance'] > 0) {
            $deficits[] = 'There is unpaid 2% remittance on the portal.';
        }

        return $deficits;
    }

    private function buildMailPayload(array $status, array $term, string $trackingToken): array
    {
        $schoolName = $this->escape($status['sch_name']);
        $schoolCode = $this->escape($status['sch_code']);
        $termLabel = $this->escape($term['termVariable'] ?? 'the active term');
        $classes = !empty($status['classes_created']) ? implode(', ', array_map([$this, 'escape'], $status['classes_created'])) : 'No class has been created.';
        $missingClasses = !empty($status['missing_classes']) ? implode(', ', array_map([$this, 'escape'], $status['missing_classes'])) : 'None recorded.';
        $deficits = !empty($status['deficits']) ? $status['deficits'] : ['The portal record is substantially complete; kindly keep it current.'];
        $trackingUrl = $this->baseUrl . '/app/mailTracker.php?t=' . rawurlencode($trackingToken);

        $deficitList = '';
        foreach ($deficits as $deficit) {
            $deficitList .= '<li>' . $this->escape($deficit) . '</li>';
        }

        $html = '
            <div style="font-family: Arial, sans-serif; color:#1f2933; line-height:1.6; font-size:14px;">
                <p>Dear PICR / Esteemed Members of the School Board,</p>
                <p>Grace and peace to you in the name of our Lord Jesus Christ.</p>
                <p>I trust this message finds you in good health and steadfast in service.</p>
                <p>
                    I write to respectfully draw your attention to the current status of <strong>' . $schoolName . ' (' . $schoolCode . ')</strong>
                    on the CRSM central portal. The portal was established to gather, harmonize and preserve essential
                    information from all CRSM schools for planning, coordination, accountability and decision-making.
                </p>
                <p>
                    Our review shows that some required information and/or remittance records for your school still need attention.
                    The responsibility for ensuring the completion and accuracy of this submission rests not only with school administrators
                    but also with the Board of Trustees as part of your collective leadership and oversight duties.
                </p>
                <h3 style="margin-top:24px;">Current Portal Status</h3>
                <table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse; width:100%; border-color:#d8dee4;">
                    <tr><td><strong>Active term reviewed</strong></td><td>' . $termLabel . '</td></tr>
                    <tr><td><strong>Last portal login</strong></td><td>' . $this->escape($status['last_login'] ?: 'No login recorded') . '</td></tr>
                    <tr><td><strong>Classes created</strong></td><td>' . $classes . '</td></tr>
                    <tr><td><strong>Teacher/personnel records created</strong></td><td>' . (int) $status['teacher_count'] . '</td></tr>
                    <tr><td><strong>Missing active-term enrolment classes</strong></td><td>' . $missingClasses . '</td></tr>
                    <tr><td><strong>Active-term enrolment population submitted</strong></td><td>' . (int) $status['active_population'] . '</td></tr>
                    <tr><td><strong>Estimated active-term 2% remittance due</strong></td><td>' . $this->formatMoney((float) $status['active_remittance_due']) . '</td></tr>
                    <tr><td><strong>Confirmed remittances made so far</strong></td><td>' . $this->formatMoney((float) $status['confirmed_remittance']) . '</td></tr>
                    <tr><td><strong>Payment awaiting confirmation</strong></td><td>' . $this->formatMoney((float) $status['awaiting_confirmation_remittance']) . '</td></tr>
                    <tr><td><strong>Outstanding / unpaid remittance on portal</strong></td><td>' . $this->formatMoney((float) $status['unpaid_remittance']) . '</td></tr>
                </table>
                <h3 style="margin-top:24px;">Items Requiring Attention</h3>
                <ul>' . $deficitList . '</ul>
                <p>
                    We kindly urge the Board to take immediate steps to ensure that the necessary information is completed,
                    updated and submitted without further delay. Where enrolment records are incomplete, please ensure that every
                    class created on the portal has its corresponding termly enrolment entry. Where remittance is outstanding,
                    please regularize the payment and evidence upload through the portal.
                </p>
                <p>
                    Should your administrators or Board encounter any challenges, kindly contact the Portal Administrator at the CRSM Headquarters
                    for the necessary support and assistance.
                </p>
                <p>Your cooperation and prompt action are deeply appreciated and will contribute significantly to the growth, unity and effectiveness of the CRSM community.</p>
                <p>
                    Yours faithfully,<br>
                    <strong>Pastor Aduradola</strong><br>
                    Chairman of the CRSM Board<br>
                    CRSM HQ Redemption City of God
                </p>
                <img src="' . $trackingUrl . '" width="1" height="1" alt="" style="display:none; max-height:1px;">
            </div>';

        $text = strip_tags(str_replace(['</tr>', '</p>', '</li>'], "\n", $html));

        return [
            'html' => $html,
            'text' => html_entity_decode($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            'payload' => [
                'school_code' => $status['sch_code'],
                'school_name' => $status['sch_name'],
                'term' => $term['termVariable'] ?? '',
                'deficits' => $status['deficits'],
                'classes_created' => $status['classes_created'],
                'missing_classes' => $status['missing_classes'],
                'teacher_count' => (int) $status['teacher_count'],
                'active_remittance_due' => (float) $status['active_remittance_due'],
                'confirmed_remittance' => (float) $status['confirmed_remittance'],
                'awaiting_confirmation_remittance' => (float) $status['awaiting_confirmation_remittance'],
                'unpaid_remittance' => (float) $status['unpaid_remittance'],
            ],
        ];
    }

    private function sendQueueItem(array $item): array
    {
        $credentials = $this->getMailCredentials();

        if (!$credentials) {
            return ['ok' => false, 'error' => 'Mail credentials are not configured.', 'transaction_id' => null];
        }

        require_once __DIR__ . '/../mailer/PHPMailer/src/Exception.php';
        require_once __DIR__ . '/../mailer/PHPMailer/src/PHPMailer.php';
        require_once __DIR__ . '/../mailer/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAutoTLS = false;
            $mail->Host = $credentials['platform'];
            $mail->Port = 465;
            $mail->Username = $credentials['public'];
            $mail->Password = $credentials['secret'];
            $mail->CharSet = 'UTF-8';
            $mail->Timeout = 30;

            $mail->setFrom($credentials['public'], 'CRSM Board');
            $mail->addReplyTo($credentials['public'], 'CRSM Portal Administrator');
            $mail->addAddress($item['recipient_email'], $item['recipient_name'] ?: $item['sch_name']);
            $mail->isHTML(true);
            $mail->Subject = $item['subject'];
            $mail->Body = $item['body_html'];
            $mail->AltBody = $item['body_text'];

            $mail->send();
            $transactionId = '';

            if (method_exists($mail, 'getSMTPInstance') && $mail->getSMTPInstance()) {
                $transactionId = (string) $mail->getSMTPInstance()->getLastTransactionID();
            }

            return ['ok' => true, 'error' => null, 'transaction_id' => $transactionId];
        } catch (Throwable $e) {
            return ['ok' => false, 'error' => $mail->ErrorInfo ?: $e->getMessage(), 'transaction_id' => null];
        }
    }

    private function getMailCredentials(): ?array
    {
        $stmt = $this->db->prepare('SELECT public, platform, secret FROM enabler WHERE id = 1 LIMIT 1');
        $stmt->execute();
        $credentials = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$credentials || empty($credentials['public']) || empty($credentials['platform']) || empty($credentials['secret'])) {
            return null;
        }

        return $credentials;
    }

    private function getActiveTerm(): array
    {
        $stmt = $this->db->query('SELECT * FROM tblcurrent_term WHERE termStatus = 1 LIMIT 1');
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: ['id' => 0, 'termVariable' => 'No active term'];
    }

    private function selectRecipientEmail(array $status): ?string
    {
        $candidates = [];

        if (!empty($status['portal_admin_email'])) {
            $candidates[] = $status['portal_admin_email'];
        }

        if (!empty($status['contact_emails'])) {
            $candidates = array_merge($candidates, array_map('trim', explode(',', $status['contact_emails'])));
        }

        foreach ($candidates as $email) {
            $valid = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($valid) {
                return $valid;
            }
        }

        return null;
    }

    private function getOrCreateCampaign(string $campaignKey, string $title, string $subject, string $createdBy): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO crsm_mail_campaigns (campaign_key, title, subject, status, created_by, created_at, updated_at)
            VALUES (?, ?, ?, 'queued', ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                subject = VALUES(subject),
                updated_at = NOW()
        ");
        $stmt->execute([$campaignKey, $title, $subject, $createdBy]);

        $stmt = $this->db->prepare('SELECT id FROM crsm_mail_campaigns WHERE campaign_key = ? LIMIT 1');
        $stmt->execute([$campaignKey]);
        $campaign = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($campaign['id'] ?? 0);
    }

    private function getQueueForSchool(int $campaignId, string $schoolCode): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM crsm_mail_queue WHERE campaign_id = ? AND sch_code = ? LIMIT 1');
        $stmt->execute([$campaignId, $schoolCode]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    private function insertQueueRow(int $campaignId, array $status, ?string $recipient, string $subject, string $bodyHtml, string $bodyText, string $queueStatus, ?string $token = null, array $payload = []): void
    {
        $token = $token ?: bin2hex(random_bytes(24));
        $stmt = $this->db->prepare("
            INSERT INTO crsm_mail_queue
                (campaign_id, sch_code, sch_name, recipient_email, recipient_name, subject, body_html, body_text, payload_json, tracking_token, status, queued_at, updated_at)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([
            $campaignId,
            $status['sch_code'],
            $status['sch_name'],
            $recipient,
            $status['sch_name'],
            $subject,
            $bodyHtml,
            $bodyText,
            json_encode($payload, JSON_UNESCAPED_SLASHES),
            $token,
            $queueStatus,
        ]);
    }

    private function updateQueueRow(int $queueId, string $recipient, string $subject, array $payload, string $queueStatus): void
    {
        $stmt = $this->db->prepare("
            UPDATE crsm_mail_queue
            SET recipient_email = ?,
                recipient_name = sch_name,
                subject = ?,
                body_html = ?,
                body_text = ?,
                payload_json = ?,
                status = ?,
                last_error = NULL,
                smtp_transaction_id = NULL,
                attempts = 0,
                reserved_at = NULL,
                sent_at = NULL,
                opened_at = NULL,
                open_count = 0,
                updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([
            $recipient,
            $subject,
            $payload['html'],
            $payload['text'],
            json_encode($payload['payload'], JSON_UNESCAPED_SLASHES),
            $queueStatus,
            $queueId,
        ]);
    }

    private function refreshCampaignCounts(int $campaignId): void
    {
        $stmt = $this->db->prepare("
            UPDATE crsm_mail_campaigns c
            SET queued_count = (SELECT COUNT(*) FROM crsm_mail_queue q WHERE q.campaign_id = c.id AND q.status <> 'skipped_no_email'),
                skipped_no_email_count = (SELECT COUNT(*) FROM crsm_mail_queue q WHERE q.campaign_id = c.id AND q.status = 'skipped_no_email'),
                updated_at = NOW()
            WHERE c.id = ?
        ");
        $stmt->execute([$campaignId]);
    }

    private function countSentLastHour(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM crsm_mail_queue WHERE sent_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['total'] ?? 0);
    }

    private function getQueuedItems(int $limit): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM crsm_mail_queue
            WHERE status = 'queued'
                AND recipient_email IS NOT NULL
                AND attempts < 3
            ORDER BY queued_at ASC, id ASC
            LIMIT " . max(1, $limit)
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function markSending(int $queueId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE crsm_mail_queue
            SET status = 'sending',
                reserved_at = NOW(),
                updated_at = NOW()
            WHERE id = ?
                AND status = 'queued'
                AND attempts < 3
        ");
        $stmt->execute([$queueId]);
        return $stmt->rowCount() === 1;
    }

    private function markSent(int $queueId, ?string $transactionId): void
    {
        $stmt = $this->db->prepare("
            UPDATE crsm_mail_queue
            SET status = 'sent',
                attempts = attempts + 1,
                smtp_transaction_id = ?,
                sent_at = NOW(),
                updated_at = NOW(),
                last_error = NULL
            WHERE id = ?
        ");
        $stmt->execute([$transactionId, $queueId]);
    }

    private function markFailed(int $queueId, int $attempts, string $error): void
    {
        $nextStatus = $attempts >= 3 ? 'failed' : 'queued';
        $stmt = $this->db->prepare("
            UPDATE crsm_mail_queue
            SET status = ?,
                attempts = ?,
                last_error = ?,
                updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$nextStatus, $attempts, $error, $queueId]);
    }

    private function ensureTables(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS crsm_mail_campaigns (
                id INT AUTO_INCREMENT PRIMARY KEY,
                campaign_key VARCHAR(80) NOT NULL UNIQUE,
                title VARCHAR(255) NOT NULL,
                subject VARCHAR(255) NOT NULL,
                status VARCHAR(32) NOT NULL DEFAULT 'queued',
                queued_count INT NOT NULL DEFAULT 0,
                skipped_no_email_count INT NOT NULL DEFAULT 0,
                created_by VARCHAR(120) NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS crsm_mail_queue (
                id INT AUTO_INCREMENT PRIMARY KEY,
                campaign_id INT NOT NULL,
                sch_code VARCHAR(50) NOT NULL,
                sch_name VARCHAR(255) NULL,
                recipient_email VARCHAR(255) NULL,
                recipient_name VARCHAR(255) NULL,
                subject VARCHAR(255) NOT NULL,
                body_html MEDIUMTEXT NULL,
                body_text MEDIUMTEXT NULL,
                payload_json MEDIUMTEXT NULL,
                tracking_token VARCHAR(64) NOT NULL UNIQUE,
                status VARCHAR(32) NOT NULL DEFAULT 'queued',
                attempts INT NOT NULL DEFAULT 0,
                last_error TEXT NULL,
                smtp_transaction_id VARCHAR(255) NULL,
                queued_at DATETIME NOT NULL,
                reserved_at DATETIME NULL,
                sent_at DATETIME NULL,
                opened_at DATETIME NULL,
                open_count INT NOT NULL DEFAULT 0,
                updated_at DATETIME NOT NULL,
                UNIQUE KEY uq_campaign_school (campaign_id, sch_code),
                INDEX idx_campaign (campaign_id),
                INDEX idx_status_queue (status, queued_at),
                INDEX idx_school (sch_code),
                INDEX idx_sent_at (sent_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $this->ensureQueueUniqueIndex();
    }

    private function releaseStaleSendingItems(): void
    {
        $this->db->exec("
            UPDATE crsm_mail_queue
            SET status = CASE WHEN attempts + 1 >= 3 THEN 'failed' ELSE 'queued' END,
                attempts = attempts + 1,
                last_error = 'Previous send attempt did not complete before the safety timeout.',
                updated_at = NOW()
            WHERE status = 'sending'
                AND reserved_at < DATE_SUB(NOW(), INTERVAL 30 MINUTE)
        ");
    }

    private function acquireLock(string $name, int $timeoutSeconds): bool
    {
        try {
            $stmt = $this->db->prepare('SELECT GET_LOCK(?, ?) AS lock_acquired');
            $stmt->execute([$name, $timeoutSeconds]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($row['lock_acquired'] ?? 0) === 1;
        } catch (Throwable $e) {
            error_log('Compliance mail DB lock unavailable: ' . $e->getMessage());
            return true;
        }
    }

    private function releaseLock(string $name): void
    {
        try {
            $stmt = $this->db->prepare('SELECT RELEASE_LOCK(?)');
            $stmt->execute([$name]);
        } catch (Throwable $e) {
            error_log('Compliance mail DB lock release failed: ' . $e->getMessage());
        }
    }

    private function ensureQueueUniqueIndex(): void
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS total
                FROM INFORMATION_SCHEMA.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = 'crsm_mail_queue'
                    AND INDEX_NAME = 'uq_campaign_school'
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ((int) ($row['total'] ?? 0) > 0) {
                return;
            }

            $this->db->exec('ALTER TABLE crsm_mail_queue ADD UNIQUE KEY uq_campaign_school (campaign_id, sch_code)');
        } catch (Throwable $e) {
            if (strpos($e->getMessage(), '1061') === false && stripos($e->getMessage(), 'Duplicate key name') === false) {
                error_log('Compliance mail unique index check failed: ' . $e->getMessage());
            }
        }
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

    private function formatMoney(float $amount): string
    {
        return '&#8358;' . number_format($amount, 2);
    }

    private function escape($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function safeRouteValue(string $value): string
    {
        return preg_replace('/[^A-Za-z0-9_.@-]/', '', trim($value));
    }
}

?>
