<?php
$title = 'Settings';
require_once "./components/nav.php";

$sql = "SELECT * FROM wallets";
$result = $link->query($sql);
$wallets = [];
if ( $result->num_rows ) {
    while($res = $result->fetch_object())
        array_push($wallets, $res);
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
                    <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $heading ?? '' ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row pd-20 height-100-p mb-30">
    <?php if ( count($wallets) ) { ?>
        <div class="col-md-6 p-2">
            <?php 
            foreach ($wallets as $wallet) { if ( $wallet->type == 'btc' ) {?>
                <div class="card-box p-4 mb-30">
                    <h4 class="mb-30">BITCOIN WALLET DETAILS</h4>
                    <form action='./forms/settings.php' method='POST'>
                        <input type="hidden" name='tab' value='<?php echo $wallet->type ?>'>
                        <div class="input-group custom d-block">
                            <input type="text" class="form-control form-control-lg" placeholder="BITCOIN ID" name='wid' value="<?php echo $wallet->wallet_id ?>" required>
                            <small>BITCOIN ID</small>
                        </div>
                        <input type='submit' class="btn btn-primary btn-lg btn-block" value='Update Wallet Info'>
                    </form>
                </div>
            <?php } } ?>
        </div>
    <?php } ?>

    <div class="col-md-6 p-2">
        <div class="card-box p-4">
            <form action='./forms/settings.php' method='POST'>
                <h4 class="mb-30">Update Password</h4>
                <input type="hidden" name='tab' value='password'>
                <div class="input-group custom">
                    <input type="password" class="form-control form-control-lg" placeholder="Current Password" name='current_password' required>
                </div>
                <div class="input-group custom">
                    <input type="password" class="form-control form-control-lg" placeholder="New Password" name='new_password' required>
                </div>
                <div class="input-group custom">
                    <input type="password" class="form-control form-control-lg" placeholder="Confirm Password" name='confirm_password' required>
                </div>

                <input type='submit' class="btn btn-primary btn-lg btn-block" value='Update Password'>
            </form>
        </div>
    </div>
</div>


<?php include_once "./components/auth_footer.php";
