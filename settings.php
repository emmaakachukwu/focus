<?php

$title = $header_title = "Settings";
require_once "./lib/auth.php";
require_once "./components/header.php";
include_once "./lib/countries.php";

?>
    <main>
        <?php include_once "./components/page_header.php"; ?>
        <section class="popular-items latest-padding">
            <div class="container">
                <form action="./forms/settings.php" method="post" class="card p-4 mb-30">
                    <h4 class="mb-30">Update your profile</h4>
                    <input type="hidden" name='tab' value='profile'>
                    <div class="row">
                        <div class="form-group mb-30 col-md-6">
                            <label for="">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $user->fname ?? '' ?>" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $user->lname ?? '' ?>" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" value="<?php echo $user->phone ?? '' ?>" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">City</label>
                            <input type="text" class="form-control" name="city" value="<?php echo $user->city ?? '' ?>" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">State</label>
                            <input type="text" class="form-control" name="state" value="<?php echo $user->state ?? '' ?>" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">Country</label>
                            <select class="form-control" name='country' required>
                                <?php foreach ( $countries as $country ) {?>
                                    <option value="<?php echo $country ?>" <?php echo strtolower($country) == strtolower($user->country) ? 'selected' : '' ?> ><?php echo $country ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn_3">Submit</button>
                    </div>
                </form>

                <form action="./forms/settings.php" method="post" class="card p-4">
                    <h4 class="mb-30">Update your password</h4>
                    <input type="hidden" name="tab" value="password">
                    <div class="row">
                        <div class="form-group mb-30 col-md-6">
                            <label for="">Current Password</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">New Password</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="form-group mb-30 col-md-6">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn_3">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php include_once "./components/footer.php";