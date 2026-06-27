<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../controller/start.inc.php';
require_once __DIR__ . '/../controller/ComplianceMailer.class.php';

$action = $argv[1] ?? 'send';
$limit = isset($argv[2]) ? (int) $argv[2] : 45;
$mailer = new ComplianceMailer($db_conn, $utility);

try {
    switch ($action) {
        case 'queue':
            $result = $mailer->queueWeeklyCampaign('cron');
            echo 'Queued campaign ' . $result['campaign_key'] . PHP_EOL;
            echo 'New: ' . $result['queued'] . ', restored: ' . $result['updated'] . ', no email: ' . $result['skipped_no_email'] . PHP_EOL;
            break;

        case 'weekly':
            $result = $mailer->queueWeeklyCampaign('cron');
            echo 'Queued campaign ' . $result['campaign_key'] . PHP_EOL;
            $sendResult = $mailer->sendQueued($limit);
            echo 'Sent: ' . $sendResult['sent'] . ', failed: ' . $sendResult['failed'] . PHP_EOL;
            break;

        case 'send':
        default:
            $sendResult = $mailer->sendQueued($limit);
            echo 'Sent: ' . $sendResult['sent'] . ', failed: ' . $sendResult['failed'] . ', remaining hourly allowance: ' . $sendResult['remaining_hourly_allowance'] . PHP_EOL;
            break;
    }
} catch (Throwable $e) {
    error_log('Compliance mail cron failed: ' . $e->getMessage());
    fwrite(STDERR, 'Compliance mail cron failed: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
