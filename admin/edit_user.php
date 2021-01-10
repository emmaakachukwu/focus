<?php

$title = 'Edit User';
require_once "./components/nav.php";
include_once "./lib/countries.php";

$id = isset($_GET['uid']) ? trim($_GET['uid']) : null;

if ( !$id || empty(trim($id)) ) {
    _404_error();
}

$sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
$result = $link->query($sql);
if ( !$result->num_rows ) {
    _404_error();
}
$user = $result->fetch_object();

function _404_error(): void {
    http_response_code(404);
    exit;
}

?>

<div class="page-header">
    <?php $heading = trim(explode('|', $title)[0]) ?>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4><?php echo $heading ?? '' ?></h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./users.php">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $heading ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box pd-20 height-100-p mb-30">
    <form action='./forms/edit_user.php?uid=<?php echo $user->id ?>' method='POST' enctype="multipart/form-data">
        <div class="row">
            <div class="input-group custom col-md-6">
                <input type="text" class="form-control form-control-lg" placeholder="First name" name='first_name' value="<?php echo $user->fname ?>" required>
            </div>
            <div class="input-group custom col-md-6">
                <input type="text" class="form-control form-control-lg" placeholder="Last name" name='last_name' value="<?php echo $user->lname ?? '' ?>" required>
            </div>
            <div class="input-group custom col-md-6">
                <input type="tel" class="form-control form-control-lg" placeholder="Phone number" name='phone_number' value="<?php echo $user->phone ?? '' ?>" >
            </div>
            <div class="input-group custom col-md-6">
                <input type="text" class="form-control form-control-lg" placeholder="Password" name='password' value="<?php echo $user->password ?? '' ?>" required>
            </div>
            <div class="input-group custom col-md-6">
                <input type="text" class="form-control form-control-lg" placeholder="City" name='city' value="<?php echo $user->city ?? '' ?>" >
            </div>
            <div class="input-group custom col-md-6">
                <input type="text" class="form-control form-control-lg" placeholder="State" name='state' value="<?php echo $user->state ?? '' ?>" >
            </div>
            <div class="input-group custom col-md-6">
                <select class="form-control" name='country' class="form-control form-control-lg">
                    <option value="" disabled selected>Country</option>
                    <?php foreach ( $countries as $country ) {?>
                        <option value="<?php echo $country ?>" <?php echo strtolower($country) == strtolower($user->country) ? 'selected' : '' ?> ><?php echo $country ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group custom col-md-6">
                <input type="number" class="form-control form-control-lg" placeholder="Balance" name='balance' value="<?php echo $user->balance ?? '' ?>" >
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="input-group mb-0">
                    <input type='submit' class="btn btn-primary btn-lg btn-block" value='Update User'>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include_once "./components/auth_footer.php";
