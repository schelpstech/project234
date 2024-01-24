<div class="px-5 py-4 container-fluid">

    <div class="mb-5 row">
        <div class="col-lg-3 col-12">
            <div class="card card-plain pe-lg-5">
                <h6 class="font-weight-semibold"> Manage Session </h6>
                <p class="text-sm">Kindly provide the details of the currrent academic Session.</p>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="card" id="basic-info">
                <div class="card-header">
                    <h5>Academic Session</h5>
                </div>
                <form role="form" class="text-start" autocomplete="off" action="../../app/acadSessionHandler.php" method="post" enctype="multipart/form-data">
                    <div class="pt-0 card-body">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Start Year</label>
                                <div class="input-group">
                                    <input name="startYear" class="form-control" type="number" minlength="4" maxlength="4" min="2023" placeholder="Start Year" required="yes">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label">End Year</label>
                                <div class="input-group">
                                    <input name="endYear" class="form-control" type="number" minlength="4" maxlength="4" min="2024" placeholder="End Year" required="yes">
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" name="CreateSession" class="mt-6 mb-0 btn btn-dark btn-sm float-end">Create and Activate Session</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-5 row">
        <div class="col-lg-3 col-12">
            <div class="card card-plain pe-lg-5">
                <h6 class="font-weight-semibold"> Manage Active Term </h6>
                <p class="text-sm">Kindly provide the details of the currrent academic term.</p>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="card" id="basic-info">
                <div class="card-header">
                    <h5>Activate Current Term</h5>
                </div>
                <form role="form" class="text-start" autocomplete="off" action="../../app/acadSessionHandler.php" method="post" enctype="multipart/form-data">
                    <div class="pt-0 card-body">
                        <div class="row">
                            <div class="col-sm-4 col-4">
                                <label class="mt-4 form-label">Select Session</label>
                                <select class="form-control" name="session" id="session" required="yes">
                                    <option value="">Select</option>
                                    <?php
                                    $option = $model->select_all('academicsession_tbl');
                                    foreach ($option as $data) {
                                        echo '<option value="'.$data['id']."-".$data['session'].'">' . $data['session'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4 col-4">
                                <label class="mt-4 form-label">Select Current Term</label>
                                <select class="form-control" name="acadTerm" id="acadTerm" required="yes">
                                    <option value="">Select</option>
                                    <?php
                                    $option = $model->select_all('term_tbl');
                                    foreach ($option as $data) {
                                    echo '<option value="' . $data['id']."-".$data['term']. '">' . $data['term'] . '</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <button type="submit" name="createNewTerm" class="mt-6 mb-0 btn btn-dark btn-sm float-end"> Activate Selected Term</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>