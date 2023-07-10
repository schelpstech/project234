<div class="px-5 py-4 container-fluid">

    <div class="mb-5 row">
        <div class="col-lg-3 col-12">
            <div class="card card-plain pe-lg-5">
                <h6 class="font-weight-semibold">Portal Admin Info</h6>
                <p class="text-sm">Kindly provide the details of the immediate contact person for the school portal account.</p>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="card" id="basic-info">
                <div class="card-header">
                    <h5>Basic Info</h5>
                </div>
                <form role="form" class="text-start" autocomplete="off" action="../../app/adminProfileHandler.php"
                method="post" enctype="multipart/form-data">
                <div class="pt-0 card-body">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Last Name</label>
                            <div class="input-group">
                                <input id="firstName" name="surName" class="form-control" type="text"
                                    value="<?php echo (!empty($adminDetails['lastName'])) ? $adminDetails['lastName'] : "" ?>"
                                    placeholder="Surname" required="yes">
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">First Name</label>
                            <div class="input-group">
                                <input id="lastName" name="firstName" class="form-control" type="text"
                                value="<?php echo (!empty($adminDetails['firstName'])) ? $adminDetails['firstName'] : "" ?>"
                                    placeholder="First name" required="yes">
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Other Name</label>
                            <div class="input-group">
                                <input id="lastName" name="otherName" class="form-control" type="text"
                                value="<?php echo (!empty($adminDetails['otherName'])) ? $adminDetails['otherName'] : "" ?>"
                                    placeholder="Other name" required="yes">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-4">
                            <label class="mt-4 form-label">Gender</label>
                            <select class="form-control" name="gender" id="gender" required="yes">
                                <option value="<?php echo (!empty($adminDetails['gender'])) ? $adminDetails['gender'] : "" ?>"><?php echo (!empty($adminDetails['gender'])) ? $adminDetails['gender'] : "Select" ?></option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </div>
                        
                        <div class="col-4">
                            <label class="mt-4 form-label">Phone Number</label>
                            <div class="input-group">
                                <input id="phone" name="phone" class="form-control" type="text"
                                value="<?php echo (!empty($adminDetails['phone'])) ? $adminDetails['phone'] : "" ?>"
                                    placeholder="08012345678" required="yes"/>
                            </div>
                        </div>

                        <div class="col-4">
                            <label class="mt-4 form-label">Job Title</label>
                            <div class="input-group">
                                <input id="jobTitle" name="jobTitle" class="form-control" type="text"
                                    value="<?php echo (!empty($adminDetails['jobTitle'])) ? $adminDetails['jobTitle'] : "" ?>"
                                    placeholder="Job Title" required="yes">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label class="mt-4 form-label">Email</label>
                            <div class="input-group">
                                <input id="emailAddress" name="emailAddress" class="form-control" type="email" onfocus=" watchToken()" onchange="validateEmail()"
                                value="<?php echo (!empty($adminDetails['email'])) ? $adminDetails['email'] : "" ?>"
                                    placeholder="example@email.com" required="yes">
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="mt-4 form-label">Token</label>
                            <div class="input-group">
                                <input id="token" name="token" class="form-control" type="text"
                                    placeholder="6 digit code" disabled>
                            </div>
                        </div>
                        
                        <div class="col-4">
                        	<button type="submit" name="profileUpdate" class="mt-6 mb-0 btn btn-dark btn-sm float-end">Update Profile</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>