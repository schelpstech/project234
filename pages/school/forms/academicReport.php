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
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('school_dashboard') ?>"
                        class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Home</strong>
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
                            <input type="number" class="form-control" name="aboveCandidates" id="aboveCandidates" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Candidates Within Average
                            </i>:<br> 70% > Grade >= 50% </label>
                        <div class="form-group">
                            <input type="number" class="form-control" name="avgCandidates" id="avgCandidates" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">Candidates Below Average
                            </i><br> Grade < 50% :</label>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="belowCandidates"
                                        id="belowCandidates" />
                                </div>
                    </div>
                </div>


                <hr>
                <button type="submit" name="submit_academic_form" class="btn btn-dark active btn-lg w-100">Submit
                    Academic Report </button>
            </form>
        </div>
    </div>
</div>

<br>
<div class="col-lg-10 offset-1 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Academic Performance Report list</h6>
                            <p class="text-sm">See information about all uploaded Termly / Sessional Academic
                                Performance Reports</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">

                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-search">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">S/N</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Academic Session</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Examination</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Class Name</th>

                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Above Average</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Average</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Below Average</th>
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Total Candidates</th>
                                    <th class="text-secondary opacity-7">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                if (!empty($academicRecords)) {
                                    foreach ($academicRecords as $data) {
                                        ?>
                                        <tr>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $count++ ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal">

                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php echo $data['session'] ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal">
                                                <div class="align-items-center">
                                                    <h6 class="mtext-sm text-dark font-weight-semibold mb-0">
                                                        <?php
                                                        echo $data['approval_abbrv']
                                                            ?>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-sm font-weight-normal" style="width:10%; word-wrap: normal;">
                                                <p class=" text-sm text-dark font-weight-semibold mb-0">
                                                    <?php
                                                    echo $data['className']
                                                        ?>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo $data['aboveCandidates']
                                                    ?>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo $data['avgCandidates']
                                                    ?>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo $data['belowCandidates']
                                                    ?>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                echo $data['numCandidates']
                                                    ?>
                                            </td>
                                            <td class="align-middle">
                                                <a  href="../../app/router.php?pageid=<?php echo base64_encode('editAcademic') ?>&reportRef=<?php echo($data['acad_record_id'])?>" class="text-secondary font-weight-bold text-xs"
                                                    data-bs-toggle="tooltip" data-bs-title="Modify Report">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </a>
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
    </div>
</div>