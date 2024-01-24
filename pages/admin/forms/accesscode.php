<div class="mb-5 row">
    <div class="col-lg-3 col-12">
        <div class="card card-plain pe-lg-5">
            <h6 class="font-weight-semibold">Change Password </h6>
        </div>
    </div>
    <div class="col-lg-9 col-12">
        <div class="card" id="password">
            <div class="card-header">
                <h5>Reset School Password</h5>
            </div>
            <form role="form" class="text-start" autocomplete="off" action="../../app/passwordReset.php" method="post"
                enctype="multipart/form-data">

                <div class="pt-0 card-body">
                    <label class="form-label">Enter School Code</label>
                    <div class="form-group">
                        <input class="form-control" type="text" id="schCode" name="schCode" required="yes"
                            placeholder="Enter School Code" onchange="fetchSchDetails();">
                    </div>
                    <label class="form-label">School Name</label>
                    <div class="form-group">
                        <select class="form-control" type="text" id="schname" name="schname">
                            <option value=""></option>
                        </select>
                    </div>
                    <button type="submit" name="resetSchPassword" class="mt-6 mb-0 btn btn-white btn-sm float-end">Reset
                        password</button>
                </div>

            </form>
        </div>
    </div>
</div>