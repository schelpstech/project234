<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">Create Support Ticket for
                        <?php echo $sch_corporate_data['sch_name'] ?>
                    </h6>
                    <p class="mb-2 text-sm mb-sm-0">A support staff will attend to your enquiry as soon as possible</p>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('school_dashboard') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Home</strong>
                    </a>
                </div>
            </div>
            <form role="form" class="text-start" autocomplete="off" action="../../app/ticketHandler.php" method="post"
                enctype="multipart/form-data">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;" hidden="yes">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">School code:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>"
                                name="sch_code" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="example-text-input" class="form-control-label">School name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sch_name"
                                value="<?php echo $sch_corporate_data['sch_name'] ?>" disabled />
                        </div>
                    </div>

                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Related support request:</label>
                            <select type="text" class="form-control" name="ticketType" required="yes">
                                <option value="">select</option>
                                <option value="1">Enquiry</option>
                                <option value="2">Complaint</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class="form-control-label">Subject</i>:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="ticketSubject" required="yes" />
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="example-text-input" class="form-control-label">Additional Information</i>:</label>
                        <div class="form-group">
                            <textarea type="text" class="form-control"  name="ticketDetails"
                                rows="10" ></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="submit_Ticket_form" class="btn btn-dark active btn-lg w-100">Create Support Ticket</button>
            </form>
        </div>
    </div>
</div>