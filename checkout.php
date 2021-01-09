<?php
$title = $header_title = "Checkout";
require_once "./components/header.php";
require_once "./lib/auth.php";

$cart = json_decode($_COOKIE['cart']);
$total = 0;
foreach ($cart as $c) {
    $total += $c->price;
}

?>
<main>
    <?php include_once "./components/page_header.php"; ?>
    <section class="popular-items latest-padding">
        <h4 class="text-center mb-30">Make payment via any of the following media.</h4>
        <div class="container mb-30">
            <div class="card p-4 mb-30">
                <h6>Pay from wallet ($ <?php echo number_format($user->balance, 2) ?>)</h6>
                <form action="./forms/checkout.php" method="post">
                    <input type="hidden" name='type' value='1'>
                    <button class="btn btn-primary">Continue</button>
                </form>
            </div>
        </div>

        <div class="container mb-30">
            <div class="card p-4 mb-30">
                <h6>Pay online now</h6>
                <form action="#" method="post">
                    <button class="btn btn-primary">Continue</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include_once "./components/footer.php";