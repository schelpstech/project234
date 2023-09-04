<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School - Annual Academic Performance Report</h6>
                    <p class="mb-2 text-sm mb-sm-0">Information provided in this form will be vetted and will not be
                        editable upon
                        approval by the secretariat</p>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('academic') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Back</strong>
                    </a>
                </div>
            </div>

            <form role="form" class="text-start" autocomplete="off" action="../../app/reportHandler.php" method="post"
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
                            <label for="example-text-input" class="form-control-label">Select Examination</label>
                            <select type="text" class="form-control" name="examination" id="examination">
                                <option value="<?php echo $selectedAcademicRecords['examination']?>"><?php echo $selectedAcademicRecords['approval_name']?></option>
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('approval_type_tbl');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['approval_abbrv'] . ' - ' . $data['approval_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">Examination Year
                            :</label>
                        <div class="form-group">
                            <select type="text" class="form-control" name="examYear" id="examYear">
                                <option value="<?php echo $selectedAcademicRecords['examYear']?>"><?php echo $selectedAcademicRecords['session']?></option>
                                <option value="">select</option>
                                <?php
                                $option = $model->select_all('academicsession_tbl');
                                foreach ($option as $data) {
                                    echo '<option value="' . $data['id'] . '">' . $data['session'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="example-text-input" class="form-control-label">Participating Class
                            :</label>
                        <div class="form-group">
                            <select type="text" class="form-control" name="classid" id="classid">
                                <option value="<?php echo $selectedAcademicRecords['classid']?>"><?php echo $selectedAcademicRecords['className']?></option>
                                <option value="">select</option>
                                <?php
                                if (!empty($createdClass)) {
                                    foreach ($createdClass as $data) {
                                        echo '<option value="' . $data['id'] . '">' . $data['className'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">You have not created any class</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Candidates Above Average
                            : <br> Grade >= 70%</label>
                        <div class="form-group">
                            <input type="number" class="form-control" name="aboveCandidates" id="aboveCandidates" value="<?php echo $selectedAcademicRecords['aboveCandidates']?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Candidates Within Average
                            </i>:<br> 70% > Grade >= 50% </label>
                        <div class="form-group">
                            <input type="number" class="form-control" name="avgCandidates" id="avgCandidates" value="<?php echo $selectedAcademicRecords['avgCandidates']?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Candidates Below Average
                            </i><br> Grade < 50% :</label>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="belowCandidates"
                                        id="belowCandidates" value="<?php echo $selectedAcademicRecords['belowCandidates']?>"/>
                                </div>
                    </div>
                </div>


                <hr>
                <button type="submit" name="Update_academic_form" class="btn btn-dark active btn-lg w-100">Update
                    Academic Report </button>
            </form>
        </div>
    </div>
</div>
