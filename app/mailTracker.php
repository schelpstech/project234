<?php
require_once __DIR__ . '/../controller/start.inc.php';
require_once __DIR__ . '/../controller/ComplianceMailer.class.php';

$token = (string) ($_GET['t'] ?? '');

try {
    $mailer = new ComplianceMailer($db_conn, $utility, null, false);
    $mailer->markOpened($token);
} catch (Throwable $e) {
    error_log('Mail open tracking failed: ' . $e->getMessage());
}

header('Content-Type: image/gif');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
echo base64_decode('R0lGODlhAQABAPAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==');
