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
                        <td>
                            <div class="cupon_text float-right">
                                <a class="btn_1" href="#">Continue</a>
                            </div>
                        </td>
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
                  <tr class="shipping_area">
                    <td></td>
                    <td></td>
                    <td>
                      <h5>Shipping</h5>
                    </td>
                    <td>
                      <div class="shipping_box">
                        <ul class="list">
                          <li>
                            Flat Rate: $5.00
                            <input type="radio" aria-label="Radio button for following text input">
                          </li>
                          <li>
                            Free Shipping
                            <input type="radio" aria-label="Radio button for following text input">
                          </li>
                          <li>
                            Flat Rate: $10.00
                            <input type="radio" aria-label="Radio button for following text input">
                          </li>
                          <li class="active">
                            Local Delivery: $2.00
                            <input type="radio" aria-label="Radio button for following text input">
                          </li>
                        </ul>
                        <h6>
                          Calculate Shipping
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </h6>
                        <select class="shipping_select">
                          <option value="1">Bangladesh</option>
                          <option value="2">India</option>
                          <option value="4">Pakistan</option>
                        </select>
                        <select class="shipping_select section_bg">
                          <option value="1">Select a State</option>
                          <option value="2">Select a State</option>
                          <option value="4">Select a State</option>
                        </select>
                        <input class="post_code" type="text" placeholder="Postcode/Zipcode" />
                        <a class="btn_1" href="#">Update Details</a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="checkout_btn_inner float-right">
                <a class="btn_1" href="#">Continue Shopping</a>
                <form action="./forms/checkout.php" method="post" class="d-inline">
                  <button type="submit" class="btn_1 checkout_btn_1">Proceed to checkout</button>
                </form>
              </div>
            </div>
          </div>
      </section>
      <!--================End Cart Area =================-->
  </main>

<?php include_once "./components/footer.php" ?>