<?php
require_once __DIR__ . '/../../../../controller/ComplianceMailer.class.php';

if (empty($_SESSION['compliance_mail_csrf'])) {
    $_SESSION['compliance_mail_csrf'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['compliance_mail_csrf'];

try {
    $complianceMailer = new ComplianceMailer($db_conn, $utility);
    $schoolStatuses = $complianceMailer->getSchoolStatuses();
    $statusReady = true;
} catch (Throwable $e) {
    error_log('Compliance status page failed: ' . $e->getMessage());
    $schoolStatuses = [];
    $statusReady = false;
}

$yesNo = function ($condition) {
    return $condition
        ? '<span class="badge badge-sm bg-gradient-success">Yes</span>'
        : '<span class="badge badge-sm bg-gradient-warning">No</span>';
};
?>

<?php if (!$statusReady): ?>
    <div class="alert bg-gradient-danger text-white">
        The compliance status page could not initialize. Please check the server log and database permissions.
    </div>
<?php else: ?>
    <div class="border shadow-xs card mb-4">
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <h6 class="font-weight-semibold text-lg mb-0">Compliance Status</h6>
                    <p class="text-sm">Portal profile, enrolment, teacher and remittance status used for school compliance emails.</p>
                </div>
                <div class="ms-auto">
                    <a href="../../app/adminRouter.php?pageid=<?php echo base64_encode('complianceMailer'); ?>" class="btn btn-sm btn-outline-dark mb-0">
                        Compliance Mailer
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive">
                <table class="table table-flush js-datatable" id="compliance-status-table">
                    <thead class="thead-light">
                        <tr>
                            <th>School</th>
                            <th>Email</th>
                            <th>Classes</th>
                            <th>Teachers</th>
                            <th>Missing Enrolment</th>
                            <th>Unpaid Remittance</th>
                            <th>Deficits</th>
                            <th>Action</th>
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
                                <td>
                                    <?php if (!empty($status['recipient_email'])): ?>
                                        <form action="../../app/complianceMailHandler.php" method="post" class="mb-0">
                                            <input type="hidden" name="csrfToken" value="<?php echo $utility->escape($csrfToken); ?>">
                                            <input type="hidden" name="returnPage" value="complianceStatus">
                                            <input type="hidden" name="schCode" value="<?php echo $utility->escape($status['sch_code']); ?>">
                                            <button type="submit" name="sendComplianceSchoolMail" class="btn btn-sm btn-info mb-0">
                                                Send
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="../../app/adminRouter.php?pageid=<?php echo base64_encode('complianceMailer'); ?>" class="badge badge-sm bg-gradient-warning">
                                            Add email
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
