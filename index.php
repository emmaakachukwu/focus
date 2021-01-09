<?php
$title = "Home | Products";
$header_title = 'Welcome to Focus Shop..';
$header_title2 = 'Shopping ends here..';
$header_subtitle = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
$header_subtitle2 = "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat is aute irure.";
require_once "./components/header.php";

$sql = "SELECT * FROM products WHERE deleted_at IS NULL ORDER BY created_at DESC";
$result = $link->query($sql);
$products = [];
if ( $result->num_rows ) {
    while($res = $result->fetch_object())
        array_push($products, $res);
}

?>
    <main>
        <?php include_once "./components/home_slider.php"; ?>
        <section class="popular-items latest-padding" id="shop_now">
            <div class="container">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <?php
                                if ( count($products) ) {
                                    foreach($products as $product) { ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                            <div class="single-popular-items mb-50 text-center">
                                                <div class="popular-img">
                                                    <?php if ( isset($product->image_path) && !empty($product->image_path) ) { ?>
                                                        <img src="./uploads/products/<?php echo $product->image_path ?>" alt="<?php echo $product->name ?>">
                                                    <?php } else {  ?>
                                                        <h3><?php echo get_inits($product->name) ?> </h3>
                                                    <?php } ?>
                                                    <div class="img-cap" onclick="add_to_cart('<?php echo $product->id ?>', '<?php echo $product->name ?>', '<?php echo $product->price ?>', '<?php echo $product->image_path ?? '' ?>')">
                                                        <span id="add-<?php echo $product->id ?>" onload="check_product('<?php echo $product->id ?>')">Add to cart</span>
                                                    </div>
                                                </div>

                                                <div class="popular-caption">
                                                    <h3><?php echo $product->name ?></h3>
                                                    <span>$ <?php echo number_format($product->price) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once "./components/shop_method.php"; ?>
    </main>

<?php include_once "./components/footer.php" ?>

<script>
    check_products_in_cart(<?php echo json_encode($products) ?>)
</script>