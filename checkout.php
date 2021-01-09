<?php
$title = $header_title = "Checkout";
require_once "./components/header.php";
require_once "./lib/auth.php";
require_once "./utils.php";

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
                <form action="./forms/checkout.php" method="post">
                    <script src="https://checkout.flutterwave.com/v3.js"></script>
                    <input type="hidden" name='type' value='2'>
                    <button type="button" class="btn btn-primary" onclick="makePayment('<?php echo $user->email?>', '<?php echo $user->phone?>', '<?php echo $user->fname?>', '<?php echo $total ?>')">Continue</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include_once "./components/footer.php" ?>

<script>
  function makePayment(email, phone, name, amount) {
    console.log(new Date().getTime());
    FlutterwaveCheckout({
      public_key: "<?php echo PUBLIC_KEY ?>",
      tx_ref: new Date().getTime(),
      amount: parseInt(amount),
      currency: "NGN",
      country: "NG",
      payment_options: "card, mobilemoneyghana, ussd",
      redirect_url: // specified redirect URL
        "http://127.0.0.1/focus/forms/checkout.php?type=2",
      meta: {
        consumer_id: 23,
        consumer_mac: "92a3-912ba-1192a",
      },
      customer: {
        email: email,
        phone_number: phone,
        name: name,
      },
      callback: function (data) {
        console.log(data);
      },
      onclose: function() {
        // close modal
      },
      customizations: {
        title: "My store",
        description: "Payment for items in cart",
        logo: "https://assets.piedpiper.com/logo.png",
      },
    });
  }
</script>