<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="mb-3 d-sm-flex align-items-center">
            <div>
                <h6 class="mb-0 text-lg font-weight-semibold">Post Job Vacancy for
                    <?php echo $sch_corporate_data['sch_name'] ?>
                </h6>
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
        <form role="form" class="text-start" autocomplete="off" action="../../app/vacancyHandler.php" method="post"
            enctype="multipart/form-data">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">School code:</label>
                        <input type="text" class="form-control" value="<?php echo $_SESSION['active'] ?>" disabled />
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Vacant Position</label>
                        <select type="text" class="form-control" name="positionId" required="yes">
                            <option value="">select</option>
                            <?php
                            $option = $model->select_all('job_position_tbl');
                            foreach ($option as $data) {
                                echo '<option value="' . $data['pos_id'] . '">' . $data['position'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Mode of Employment</label>
                        <select type="text" class="form-control" name="modeEmployment" required="yes">
                            <option value="">select</option>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="example-text-input" class="form-control-label">Application Deadline</i>:</label>
                    <div class="form-group">
                        <input type="date" class="form-control" name="dateEmployment" required="yes" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="example-text-input" class="form-control-label">Job Title</i>:</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" required="yes" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Minimum Required
                            Qualification</label>
                        <select type="text" class="form-control" name="qualification" required="yes">
                            <option value="">select</option>
                            <?php
                            $option = $model->select_all('qualification_tbl');
                            foreach ($option as $data) {
                                echo '<option value="' . $data['id'] . '">' . $data['qualification'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <label for="example-text-input" class="form-control-label">Job Description</i>:</label>
                    <div class="form-group">
                        <textarea type="text" class="form-control" id="wysiwyg_editor" name="jobDescription" row="10"
                            required="yes"></textarea>
                    </div>
                </div>
            </div>



            <hr>
            <button type="submit" name="submitVacancyPost" class="btn btn-dark active btn-lg w-100">Submit Job Vacancy
                Post
                Request</button>

        </form>

    </div>
</div>
<br>

<div class="border shadow-xs card">
    <div class="pb-0 card-header border-bottom">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Manage Job Vacancy</h6>
                        <p class="text-sm">See information about all Job Vacancies of the school</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">

                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-search">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Vacancy Status
                                </th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Job Title </th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                    Duration</th>
                                <th class="text-secondary opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if (!empty($vacancy_data)) {
                                foreach ($vacancy_data as $data) {
                                    ?>
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <?php
                                            echo ($data['vac_vetted'] == 1) ?
                                                '
                                                        <button class="btn btn-success me-2" type="button">Active</button>
                                                    ' :
                                                '
                                                        <button class="btn btn-dark me-2" disabled type="button">Pending</button>
                                                    ';
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <p class="text-sm text-dark font-weight-semibold mb-0 ">
                                                <strong>
                                                    <?php
                                                    echo $data['vac_job_title']
                                                        ?> -
                                                </strong><br>
                                                <?php
                                                echo $data['position']
                                                    ?>
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="text-sm text-dark font-weight-semibold mb-0 ">
                                                Starts :
                                                <?php
                                                echo $data['vac_post_date']
                                                    ?> <br>
                                                Ending :
                                                <?php
                                                echo $data['vac_app_deadline']
                                                    ?>
                                            </p>
                                        </td>

                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="javascript:;">Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:;">View Applicants</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:;">Deactivate </a></li>
                                                </ul>
                                            </div>
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