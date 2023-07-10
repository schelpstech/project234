<?php
if (isset($_SESSION['ticketid'])) {
    $tblName = '_tbl_conversation';
    $conditions = [
        'where' => [
            '_tbl_conversation.ticketID' => $_SESSION['ticketid'],
        ],
        'joinl' => [
            '_tbl_ticket' => ' on _tbl_ticket.ticketRefNumber = _tbl_conversation.ticketID',
        ],
        'order_by' => '_tbl_conversation.rec_time DESC',
    ];
    $chatHistory = $model->getRows($tblName, $conditions);

    $tblName = '_tbl_ticket';
    $conditions = [
        'where' => [
            'ticketRefNumber' => $_SESSION['ticketid'],
        ],
        'return_type' => 'single',
    ];
    $chatDetails = $model->getRows($tblName, $conditions);

}
?>
<div class="px-5 py-4 container-fluid">
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="pb-0 card-header">
                    <h6>Ticket
                        <?php echo $_SESSION['ticketid'] . " : " . $chatDetails['ticketSubject'] ?>:
                    </h6>
                </div>
                <div class="p-3 card-body">
                    <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
                        <?php
                        if (!empty($chatHistory)) {
                            foreach ($chatHistory as $data) {
                                ?>
                                <div class="mb-4 timeline-block">
                                    <span class="timeline-step">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="mb-0 text-sm text-dark font-weight-bold">
                                            <?php echo $data['sent_by'] ?> <small><i> said : </i></small>
                                        </h6>
                                        <p class="mt-1 mb-0 text-xs text-secondary font-weight-bold">

                                        </p>
                                        <p class="mt-3 mb-2 text-sm">
                                            <?php echo ($data['message']) ?>
                                        </p>
                                        <span class="border-0 badge border-radius-xl badge-primary">
                                            <?php echo $data['RecordTime'] ?>
                                        </span>
                                    </div>
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
                    <form role="form" class="text-start" autocomplete="off" action="../../app/ticketHandler.php"
                        method="post" enctype="multipart/form-data">
                        <hr>
                        <div class="row">

                            <div class="col-md-4" style="display: none;" hidden="yes">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">School code:</label>
                                    <input type="text" class="form-control"
                                        value="<?php echo $chatDetails['schCode'] ?>" name="sch_code" />
                                </div>
                            </div>
                            <div class="col-md-4" style="display: none;" hidden="yes">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ticket ID:</label>
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['ticketid'] ?>"
                                        name="ticketid" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="example-text-input" class="form-control-label">Message</i>:</label>
                                <div class="form-group">
                                    <textarea type="text" class="form-control" name="ticketDetails"
                                        rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" name="replyTicketForm"
                            class="btn btn-dark active btn-lg w-100">Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>