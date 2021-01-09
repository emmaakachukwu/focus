<?php

$title = $header_title = "Deposit";
require_once "./lib/auth.php";
require_once "./components/header.php";

$sql = "SELECT * FROM wallets";
$result = $link->query($sql);
$wallets = [];
if ( $result->num_rows ) {
    while($res = $result->fetch_object())
        array_push($wallets, $res);
}

?>
    <main>
        <?php include_once "./components/page_header.php"; ?>
        <section class="popular-items latest-padding">
            <h4 class="text-center mb-30">Make payment via any of the following media and upload an evidence of payment below. An admin will get back to you.</h4>
            <div class="container mb-30">
                <?php foreach ($wallets as $wallet) { if ( $wallet->type == 'btc' ) { ?>
                    <div class="card p-4 mb-30">
                        <h6><?php echo $wallet->wallet_id ?></h6>
                        <p><?php echo strtoupper($wallet->type) ?></p>
                    </div>
                <?php } } ?>
            </div>

            <div class="container">
                <form action="./forms/deposit.php" method="post" enctype="multipart/form-data" class="card p-4">
                    <h4 class="mb-30">Upload evidence of payment</h4>
                    <div class="form-group mb-30">
                        <label for="">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount paid" required>
                    </div>
                    <div class="form-group mb-30">
                        <label for="">Select Image File</label>
                        <input type="file" class="form-control" name="file" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn_3">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php include_once "./components/footer.php";