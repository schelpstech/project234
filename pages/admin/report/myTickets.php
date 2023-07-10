<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card-header border-bottom pb-0">
            <div class="d-sm-flex align-items-center">
                <div>
                    <h6 class="font-weight-semibold text-lg mb-0">My Support Tickets</h6>
                    <p class="text-sm">See information about all personnel of the school</p>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">

            <div class="table-responsive">
                <table class="table table-flush" id="datatable-search">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Ticket ID</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                Subject</th>
                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                Ticket Status</th>
                            <th class="text-secondary opacity-7">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($ticketlog)) {
                            foreach ($ticketlog as $data) {
                                ?>
                                <tr>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                            <?php echo $data['ticketRefNumber'] ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                            <?php
                                            switch ($data['ticketType']) {
                                                case '1':
                                                    echo '<strong> Enquiry - </strong>' . $data['ticketSubject'];
                                                    break;
                                                case '2':
                                                    echo '<strong>Complaint - </strong>' . $data['ticketSubject'];
                                                    break;
                                            }
                                            ?>
                                        </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <?php
                                        if ($data['ticketStatus'] == 0) {
                                            echo '<a  href="./index.php?pageid=' . base64_encode('conversation') . '&ticketid='.$data['ticketRefNumber'].'" class="btn btn-danger btn-sm me-1" type="button">closed</a>';
                                        } elseif ($data['ticketStatus'] == 1 && $data['lastReply'] == 11) {
                                            echo '<a href="./index.php?pageid=' . base64_encode('conversation') . '&ticketid='.$data['ticketRefNumber'].'" class="btn btn-warning btn-sm me-1" type="button">Awaiting feedback</a>';
                                        } elseif ($data['ticketStatus'] == 1 && $data['lastReply'] == 22) {
                                            echo '<a href="./index.php?pageid=' . base64_encode('conversation') . '&ticketid='.$data['ticketRefNumber'].'" class="btn btn-dark btn-sm me-1" type="button">Answered</a>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                            <?php echo $data['RecordTime'] ?>
                                        </p>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>