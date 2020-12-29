<?php

$title = "Signup";
require_once "./lib/header.php";
?>
    <div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="vendors/images/register-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="wizard-content">
                            <div class="login-title">
                                <h2 class="text-center text-primary">Signup on <?php echo $app_name ?></h2>
                            </div>
							<form action='./forms/signup.php' method='POST'>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email Address*</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" name='email' value='<?php echo session_val('email') ?>' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Username*</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name='username' value='<?php echo session_val('username') ?>' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">First Name*</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name='first_name' value='<?php echo session_val('first_name') ?>' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Last Name*</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name='last_name' value='<?php echo session_val('last_name') ?>' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Password*</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name='password' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Confirm Password*</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name='confirm_password' required>
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox my-4">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name='agree' required>
                                    <label class="custom-control-label" for="customCheck1">I have read and agreed to the terms of services</label>
                                </div>
                                <div class="input-group mb-0">
                                    <input type='submit' class="btn btn-primary btn-lg btn-block" value='Create Account'>
                                </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php include_once "./lib/footer.php";