<?php
$title = $header_title = "Cart";
require_once "./components/header.php";

$cart = json_decode($_COOKIE['cart']);
$total = 0;
foreach ($cart as $c) {
  $total += $c->price;
}

?>

<main>
    <?php include_once "./components/page_header.php"; ?>
      <section class="cart_area section_padding">
        <div class="container">
          <div class="cart_inner">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
                    <?php if ( count($cart) ) { foreach ($cart as $c) { ?>
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="media-body">
                                        <p><?php echo $c->name ?></p>
                                    </div>
                                    <div class="d-flex">
                                        <?php if ( isset($c->image) && !empty($c->image) ) { ?>
                                            <img src="./uploads/products/<?php echo $c->image ?>" alt="<?php echo $c->name ?>" class="image-fluid" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>$ <?php echo number_format($c->price, 2) ?></h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <span class="input-number-decrement"> <i class="ti-minus"></i></span>
                                    <input class="input-number" type="text" value="1" min="0" max="10">
                                    <span class="input-number-increment"> <i class="ti-plus"></i></span>
                                </div>
                            </td>
                            <td>
                                <h5>$&nbsp;<?php echo number_format(intval($c->price) * intval($c->quantity), 2) ?></h5>
                            </td>
                        </tr>
                    <?php } } ?>
                  
                    <tr class="bottom_button">
                        <td>
                            <button type="button" class="btn btn-danger rounded">Remove All</a>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td>
                      <h5>Subtotal</h5>
                    </td>
                    <td>
                      <h5>$ <?php echo number_format($total, 2) ?></h5>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="checkout_btn_inner float-right">
                <a class="btn_1" href="./index.php">Continue Shopping</a>
                <form action="./forms/cart.php" method="post" class="d-inline">
                  <button type="submit" class="btn_1 checkout_btn_1">Proceed to checkout</button>
                </form>
              </div>
            </div>
          </div>
      </section>
      <!--================End Cart Area =================-->
  </main>

<?php include_once "./components/footer.php" ?>