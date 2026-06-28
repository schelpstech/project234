<?php
if (empty($_SESSION['ticket_csrf'])) {
    $_SESSION['ticket_csrf'] = bin2hex(random_bytes(32));
}
$ticketCsrf = $_SESSION['ticket_csrf'];
$ticketOpen = (int) ($chatDetails['ticketStatus'] ?? 1) === 1;
?>
<div class="px-5 py-4 container-fluid">
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="pb-0 card-header border-bottom">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Ticket <?php echo $utility->escape($_SESSION['ticketid'] . ' : ' . $chatDetails['ticketSubject']); ?></h6>
                            <p class="text-sm mb-0"><?php echo $ticketOpen ? 'Open conversation with CRSM support.' : 'This ticket is closed.'; ?></p>
                        </div>
                        <div class="ms-auto">
                            <span class="badge badge-sm <?php echo $ticketOpen ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                                <?php echo $ticketOpen ? 'Open' : 'Closed'; ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-3 card-body">
                    <div class="support-thread">
                        <?php
                        if (!empty($chatHistory)) {
                            foreach ($chatHistory as $data) {
                                $isSchool = ($data['sent_by'] === $_SESSION['active']);
                                ?>
                                <div class="support-message <?php echo $isSchool ? 'is-school' : 'is-admin'; ?>">
                                    <div class="support-message-meta">
                                        <strong class="text-sm"><?php echo $utility->escape($isSchool ? 'You' : 'CRSM Support'); ?></strong>
                                        <span class="text-xs text-secondary"><?php echo $utility->escape($data['RecordTime']); ?></span>
                                    </div>
                                    <div class="support-message-body"><?php echo nl2br($utility->escape($data['message'])); ?></div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
        <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">Submit new reply
                    </h6>
                    
                </div>
            </div>
            <form role="form" class="text-start" autocomplete="off" action="../../app/ticketHandler.php" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="ticketCsrf" value="<?php echo $utility->escape($ticketCsrf); ?>">
                <hr>
                <div class="row">
                    
                    <div class="col-md-4" style="display: none;" hidden="yes">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>"
                                name="sch_code" />
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;" hidden="yes">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['ticketid'] ?>"
                                name="ticketid" />
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;" hidden="yes">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['ticketid'] ?>"
                                name="ticketStatus" />
                        </div>
                    </div>

                </div>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <label for="example-text-input" class="form-control-label">Message</i>:</label>
                        <div class="form-group">
                        <textarea type="text" class="form-control" name="ticketDetails"
                                rows="8" <?php echo $ticketOpen ? '' : 'disabled'; ?>></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="replyTicketForm" class="btn btn-dark active btn-lg w-100" <?php echo $ticketOpen ? '' : 'disabled'; ?>>Reply</button>
            </form>
            <?php if ($ticketOpen): ?>
                <form action="../../app/ticketHandler.php" method="post" class="mt-3">
                    <input type="hidden" name="ticketCsrf" value="<?php echo $utility->escape($ticketCsrf); ?>">
                    <input type="hidden" name="ticketid" value="<?php echo $utility->escape($_SESSION['ticketid']); ?>">
                    <input type="hidden" name="sch_code" value="<?php echo $utility->escape($_SESSION['active']); ?>">
                    <button type="submit" name="closeTicketForm" class="btn btn-outline-danger w-100">Close Ticket</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
        </div>
    </div>
