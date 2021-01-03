<?php
$title = "Make Payment";
$header_title = 'Make Payment';
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
                <?php } if ( $wallet->type == 'bank' ) { ?>
                    <div class="card p-4 mb-30">
                        <h6><?php echo $wallet->wallet_id ?></h6>
                        <p class="mb-30">ACCOUNT NUMBER</p>
                        <h6><?php echo $wallet->bank_name ?></h6>
                        <p class="mb-30">BANK NAME</p>
                        <h6><?php echo $wallet->bank_address ?></h6>
                        <p class="mb-30">BANK ADDRESS</p>
                        <h6><?php echo $wallet->recipient_name ?></h6>
                        <p class="mb-30">RECIPIENT NAME</p>
                        <h6><?php echo $wallet->swift_code ?></h6>
                        <p>SWIFT CODE</p>
                    </div>
                <?php } if ( $wallet->type == 'native_lang' ) { ?>
                    <div class="card p-4 mb-30">
                        <h6><?php echo $wallet->wallet_id ?></h6>
                        <p class="mb-30">Номер счета</p>
                        <h6><?php echo $wallet->bank_name ?></h6>
                        <p class="mb-30">Название банка</p>
                        <h6><?php echo $wallet->bank_address ?></h6>
                        <p class="mb-30">Адрес банка</p>
                        <h6><?php echo $wallet->recipient_name ?></h6>
                        <p class="mb-30">Имя получателя</p>
                        <h6><?php echo $wallet->swift_code ?></h6>
                        <p>SWIFT-код</p>
                    </div>
                <?php } } ?>
            </div>

            <div class="container">
                <form action="./forms/payment.php" method="post" enctype="multipart/form-data" class="card p-4">
                    <h4 class="mb-30">Upload evidence of payment</h4>
                    <div class="form-group mb-30">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="form-group mb-30">
                        <label for="">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount paid" required>
                    </div>
                    <div class="form-group mb-30">
                        <label for="">Select File</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn_3">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php include_once "./components/footer.php";