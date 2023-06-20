    <div class="mb-5 row">
        <div class="col-lg-3 col-12">
            <div class="card card-plain pe-lg-5">
                <h6 class="font-weight-semibold">Change Password </h6>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="card" id="password">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <form role="form" class="text-start" autocomplete="off" action="../../app/passwordHandler.php"
                method="post" enctype="multipart/form-data">
                <div class="pt-0 card-body">
                    <label class="form-label">Current password</label>
                    <div class="form-group">
                        <input class="form-control" type="password" id="oldPassword" name="oldPassword" required="yes" placeholder="Current password">
                    </div>
                    <label class="form-label">New password</label>
                    <div class="form-group">
                        <input class="form-control" type="password" id="newPassword" required="yes" minlength="8" maxlength = "16"
                        name="newPassword" onchange="checkpassword()" placeholder="New password">
                    </div>
                    <label class="form-label">Confirm new password</label>
                    <div class="form-group">
                        <input class="form-control" type="password" id="confirmPassword" required="yes" name="confirmPassword"  minlength="8" maxlength = "16"
                         onchange="checkpassword()" placeholder="Confirm password">
                    </div>
                    <button type="button" class="mt-6 mb-0 btn btn-white btn-sm float-end" onclick="showPassword();">Hide/Show password</button>
                    <h5 class="mt-5">Password requirements</h5>
                    <p class="mb-2 text-muted">
                        Please follow this guide for a strong password:
                    </p>
                    <ul class="mb-0 text-muted ps-4 float-start"><i>
                        <li>
                            <span class="text-sm">Minimum of 8 characters</span>
                        </li>
                        <li>
                            <span class="text-sm">Maximum 16 characters</span>
                        </li>
                        <li>
                            <span class="text-sm">Password must be something you can remember</span>
                        </li>
                        <li>
                            <span class="text-sm">Change it often</span>
                        </li>
                    </i></ul>
                    
                    <button type="submit" name="changePassword" class="mt-6 mb-0 btn btn-white btn-sm float-end">Update password</button>
                </div>
                </form>
            </div>
        </div>
    </div>
   