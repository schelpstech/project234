<div class="col-lg-8 offset-2 col-md-12 ">
    <div class="border shadow-xs card">
        <div class="pb-0 card-header border-bottom">
            <div class="mb-3 d-sm-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-lg font-weight-semibold">CRSM School Profile Creation Form</h6>
                    <p class="mb-2 text-sm mb-sm-0">School Code will be automatically generated using the state and lga fields</p>
                </div>
                <div class="ms-auto d-flex">
                    <a type="button" href="../../app/router.php?pageid=<?php echo base64_encode('school_dashboard') ?>" class="mb-0 btn btn-sm btn-dark me-2">
                        <strong>Home</strong>
                    </a>
                </div>
            </div>

            <form role="form" class="text-start" autocomplete="off" action="../../app/schoolProfileMgr.php" method="post" enctype="multipart/form-data">
                <hr>
                <div class="row">
                <div class="col-md-4">
                        <label for="example-text-input" class="form-control-label">School Code</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sch_code"  required="yes" minlength="11" maxlength="11"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <label for="example-text-input" class="form-control-label">School name <i><small>(as it appears on certificates)</i></small></label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="sch_name"  required="yes" />
                        </div>
                    </div>

                </div>
                <hr>
                
               
                <button type="submit" name="create_school_form" class="btn btn-dark active btn-lg w-100">Create School
                    Profile</button>
            </form>
        </div>
    </div>
</div>