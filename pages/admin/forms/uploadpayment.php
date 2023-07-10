<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School - Upload Evidence of Payment for Invoice #
                        <?php echo $_SESSION['invoiceNum'] ?>
                    </h6>
                    <p class="mb-2 text-sm mb-sm-0">Information provided in this form will be vetted and will not be
                        editable upon
                        approval by the secretariat</p>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('transaction') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Back</strong>
                    </a>
                </div>
            </div>

            <form role="form" class="text-start" autocomplete="off" action="../../app/paymentHandler.php" method="post"
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
                            <input type="text" class="form-control" name="sch_name" disabled
                                value="<?php echo $sch_corporate_data['sch_name'] ?>" />
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Invoice Details</label>
                            <select type="text" class="form-control" name="invReference" id="invReference">
                                <option value="<?php echo $invoiceDetails['invReference'] ?>">
                                    <?php echo $invoiceDetails['termVariable'] . ' - ' . $invoiceDetails['invType'] ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Invoice Amount</label>
                            <select type="text" class="form-control" name="termAmount" id="termAmount">
                                <option value="<?php echo $invoiceDetails['invAmount'] ?>">
                                    <?php echo $invoiceDetails['invAmount'] ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Payment Type</label>
                            <select type="text" class="form-control" name="paymentType" id="paymentType">
                                <option value="">select</option>
                                <option value="full">Full</option>
                                <option value="part">Part</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Evidence of Payment</label>
                            <input type="file" class="form-control" name="Paymentevidence" id="Paymentevidence"
                                accept="image/png, image/gif, image/jpeg" size="524288" onchange="previewImage(this)" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <img id="preview" src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; max-height: 100%;">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="confirmInvoice"
                                onchange="toggleButton()">
                            <label class="custom-control-label" for="customCheck1">I affirm that the evidence of payment
                                is correct. </label>
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" name="uploadPaymentEvidence" id="submitInvoice" disabled
                    class="btn btn-dark active btn-lg w-100">Upload Evidence
                    of Payment
                </button>
            </form>
        </div>
    </div>
</div>