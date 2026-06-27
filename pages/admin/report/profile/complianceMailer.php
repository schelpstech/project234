<?php
require_once __DIR__ . '/../../../../controller/ComplianceMailer.class.php';

if (empty($_SESSION['compliance_mail_csrf'])) {
    $_SESSION['compliance_mail_csrf'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['compliance_mail_csrf'];

try {
    $complianceMailer = new ComplianceMailer($db_conn, $utility);
    $queueSummary = $complianceMailer->getQueueSummary();
    $campaigns = $complianceMailer->getCampaigns();
    $queueReport = $complianceMailer->getQueueReport();
    $schoolsWithoutEmail = $complianceMailer->getSchoolsWithoutEmail();
    $schoolStatuses = $complianceMailer->getSchoolStatuses();
    $mailerReady = true;
} catch (Throwable $e) {
    error_log('Compliance mailer page failed: ' . $e->getMessage());
    $queueSummary = [];
    $campaigns = [];
    $queueReport = [];
    $schoolsWithoutEmail = [];
    $schoolStatuses = [];
    $mailerReady = false;
}

$statusBadge = function ($status) {
    $classes = [
        'queued' => 'bg-gradient-secondary',
        'sending' => 'bg-gradient-info',
        'sent' => 'bg-gradient-success',
        'opened' => 'bg-gradient-primary',
        'failed' => 'bg-gradient-danger',
        'skipped_no_email' => 'bg-gradient-warning',
    ];
    $class = $classes[$status] ?? 'bg-gradient-dark';
    return '<span class="badge badge-sm ' . $class . '">' . htmlspecialchars(str_replace('_', ' ', $status), ENT_QUOTES, 'UTF-8') . '</span>';
};

$yesNo = function ($condition) {
    return $condition ? '<span class="badge badge-sm bg-gradient-success">Yes</span>' : '<span class="badge badge-sm bg-gradient-warning">No</span>';
};
?>

<style>
    @media print {
        .no-print,
        .sidenav,
        .navbar {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
        }

        .print-card {
            box-shadow: none !important;
            border: 0 !important;
        }
    }
</style>

<?php if (!$mailerReady): ?>
    <div class="alert bg-gradient-danger text-white">
        The compliance mailer could not initialize. Please check the server log and database permissions.
    </div>
<?php else: ?>
    <div class="row no-print">
        <div class="col-lg-8">
            <div class="border shadow-xs card mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Weekly Compliance Mail Queue</h6>
                            <p class="text-sm">Prepare the weekly board notice and send queued emails within the 50-mails-per-hour server limit.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="../../app/complianceMailHandler.php" method="post">
                                <input type="hidden" name="csrfToken" value="<?php echo $utility->escape($csrfToken); ?>">
                                <button type="submit" name="queueWeeklyComplianceMail" class="btn btn-dark w-100">
                                    Build Weekly Queue
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="../../app/complianceMailHandler.php" method="post" class="d-flex gap-2">
                                <input type="hidden" name="csrfToken" value="<?php echo $utility->escape($csrfToken); ?>">
                                <input type="number" name="sendLimit" class="form-control" value="45" min="1" max="50">
                                <button type="submit" name="sendComplianceMailQueue" class="btn btn-info w-100">
                                    Send Queue
                                </button>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <p class="text-sm mb-0">
                        Cron commands:
                        <code>php app/complianceMailCron.php queue</code> weekly, then
                        <code>php app/complianceMailCron.php send 45</code> hourly until the queue is empty.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="border shadow-xs card mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Add Missing School Email</h6>
                    <p class="text-sm">Use this when a school has no email on the portal.</p>
                </div>
                <div class="card-body">
                    <form action="../../app/complianceMailHandler.php" method="post">
                        <input type="hidden" name="csrfToken" value="<?php echo $utility->escape($csrfToken); ?>">
                        <div class="mb-3">
                            <label class="form-control-label">School</label>
                            <select name="schCode" class="form-control" required>
                                <option value="">Select school</option>
                                <?php foreach ($schoolsWithoutEmail as $school): ?>
                                    <option value="<?php echo $utility->escape($school['sch_code']); ?>">
                                        <?php echo $utility->escape($school['sch_code'] . ' - ' . $school['sch_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-control-label">Email address</label>
                            <input type="email" name="emailAddress" class="form-control" required>
                        </div>
                        <button type="submit" name="addComplianceSchoolEmail" class="btn btn-dark w-100">
                            Add Email
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-print">
        <?php foreach (['queued', 'sent', 'opened', 'failed', 'skipped_no_email'] as $status): ?>
            <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="border shadow-xs card h-100">
                    <div class="card-body">
                        <p class="text-sm mb-1 text-secondary"><?php echo ucwords(str_replace('_', ' ', $status)); ?></p>
                        <h4 class="mb-0"><?php echo (int) ($queueSummary[$status] ?? 0); ?></h4>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="border shadow-xs card mb-4 no-print">
        <div class="card-header border-bottom pb-0">
            <h6 class="font-weight-semibold text-lg mb-0">Recent Campaigns</h6>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive">
                <table class="table table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>Campaign</th>
                            <th>Subject</th>
                            <th>Queued</th>
                            <th>No Email</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campaigns as $campaign): ?>
                            <tr>
                                <td><?php echo $utility->escape($campaign['campaign_key']); ?></td>
                                <td><?php echo $utility->escape($campaign['subject']); ?></td>
                                <td><?php echo (int) $campaign['queued_count']; ?></td>
                                <td><?php echo (int) $campaign['skipped_no_email_count']; ?></td>
                                <td><?php echo $utility->escape($campaign['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="border shadow-xs card mb-4 print-card">
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <h6 class="font-weight-semibold text-lg mb-0">Compliance Mail Delivery Report</h6>
                    <p class="text-sm">SMTP accepted mail counts as sent. Open tracking depends on the recipient allowing images.</p>
                </div>
                <div class="ms-auto no-print">
                    <button type="button" class="btn btn-sm btn-dark" onclick="window.print()">Print Report</button>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive">
                <table class="table table-flush" id="datatable-search">
                    <thead class="thead-light">
                        <tr>
                            <th>Queued</th>
                            <th>School</th>
                            <th>Recipient</th>
                            <th>Status</th>
                            <th>Attempts</th>
                            <th>Sent</th>
                            <th>Opened</th>
                            <th>SMTP / Error</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($queueReport as $row): ?>
                            <tr>
                                <td><?php echo $utility->escape($row['queued_at']); ?></td>
                                <td>
                                    <strong><?php echo $utility->escape($row['sch_code']); ?></strong><br>
                                    <span class="text-sm"><?php echo $utility->escape($row['sch_name']); ?></span>
                                </td>
                                <td><?php echo $utility->escape($row['recipient_email'] ?: 'No email on portal'); ?></td>
                                <td><?php echo $statusBadge($row['status']); ?></td>
                                <td><?php echo (int) $row['attempts']; ?></td>
                                <td><?php echo $utility->escape($row['sent_at'] ?: '-'); ?></td>
                                <td>
                                    <?php echo $utility->escape($row['opened_at'] ?: '-'); ?>
                                    <?php if ((int) $row['open_count'] > 0): ?>
                                        <br><span class="text-xs"><?php echo (int) $row['open_count']; ?> open(s)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-sm">
                                    <?php echo $utility->escape($row['smtp_transaction_id'] ?: ($row['last_error'] ?: '-')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="border shadow-xs card mb-4 no-print">
        <div class="card-header border-bottom pb-0">
            <h6 class="font-weight-semibold text-lg mb-0">Portal Status Preview</h6>
            <p class="text-sm">This is the same status source used to build each school email.</p>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive">
                <table class="table table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>School</th>
                            <th>Email</th>
                            <th>Classes</th>
                            <th>Teachers</th>
                            <th>Missing Enrolment</th>
                            <th>Unpaid Remittance</th>
                            <th>Deficits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schoolStatuses as $status): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $utility->escape($status['sch_code']); ?></strong><br>
                                    <span class="text-sm"><?php echo $utility->escape($status['sch_name']); ?></span>
                                </td>
                                <td><?php echo $yesNo(!empty($status['recipient_email'])); ?></td>
                                <td><?php echo (int) $status['class_count']; ?></td>
                                <td><?php echo (int) $status['teacher_count']; ?></td>
                                <td><?php echo !empty($status['missing_classes']) ? $utility->escape(implode(', ', $status['missing_classes'])) : 'None'; ?></td>
                                <td><?php echo $utility->money((float) $status['unpaid_remittance']); ?></td>
                                <td class="text-sm">
                                    <?php echo !empty($status['deficits']) ? $utility->escape(implode(' | ', $status['deficits'])) : 'None'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
