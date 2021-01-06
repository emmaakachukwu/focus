<?php
$title = $header_title = "Signup";
require_once "./components/header.php";

?>

<main>
    <?php include_once "./components/page_header.php"; ?>
    <section class="login_part section_padding ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Welcome <br>
                                Please Sign up now</h3>
                            <form class="row contact_form" action="./forms/signup.php" method="post">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo session_val('first_name') ?>"
                                        placeholder="Enter your first name" required>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo session_val('last_name') ?>"
                                        placeholder="Enter your last name" required>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo session_val('email') ?>"
                                        placeholder="Enter your email address" required>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo session_val('username') ?>"
                                        placeholder="Enter your preferred username" required>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" value=""
                                        placeholder="Enter password" required>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" value=""
                                        placeholder="Confirm password" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="creat_account d-flex align-items-center">
                                        <input type="checkbox" id="f-option" name="agree" required>
                                        <label for="f-option">Agree to terms and condition</label>
                                    </div>
                                    <button type="submit" class="btn_3">
                                        signup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "./components/footer.php";
