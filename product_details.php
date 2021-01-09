<?php
$title = $header_title = "Product detail";
require_once "./components/header.php";

$id = isset($_GET['product_id']) ? trim($_GET['product_id']) : null;

if ( !$id || empty(trim($id)) ) {
    _404_error();
}

$sql = "SELECT * FROM products WHERE id = '$id' AND deleted_at IS NULL LIMIT 1";
$result = $link->query($sql);
if ( !$result->num_rows )
    _404_error();

$product = $result->fetch_object();

function _404_error(): void {
    http_response_code(404);
    exit;
}

?>
    <main>
        <?php include_once "./components/page_header.php"; ?>
        <!--================Single Product Area =================-->
        <div class="product_image_area">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="product_img_slide owl-carousel">
                        <div class="single_product_img">
                            <?php if ( isset($product->image_path) && !empty($product->image_path) ) { ?>
                                <img src="./uploads/products/<?php echo $product->image_path ?>" alt="#" class="img-fluid">
                            <?php } ?>
                        </div>
                        <!-- <div class="single_product_img">
                            <img src="assets/img/gallery/gallery01.png" alt="#" class="img-fluid">
                        </div>
                        <div class="single_product_img">
                            <img src="assets/img/gallery/gallery1.png" alt="#" class="img-fluid">
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-8">
                <div class="single_product_text text-center">
                    <h3><?php echo $product->name ?></h3>
                    <p><?php echo $product->desc ?? 'No description available' ?></p>
                    <div class="card_area">
                        <div class="product_count_area">
                            <p>Quantity</p>
                            <div class="product_count d-inline-block">
                                <span class="product_count_item inumber-decrement"> <i class="ti-minus"></i></span>
                                <input class="product_count_item input-number" type="text" value="1" min="0" max="10" id="qty-<?php echo $product->id ?>">
                                <span class="product_count_item number-increment"> <i class="ti-plus"></i></span>
                            </div>
                            <p>$ <?php echo number_format($product->price, 2) ?></p>
                        </div>
                    <div class="add_to_cart" onclick="add_to_cart('<?php echo $product->id ?>', '<?php echo $product->name ?>', '<?php echo $product->price ?>', '<?php echo $product->image_path ?? '' ?>', document.querySelector('#qty-<?php echo $product->id ?>').value)">
                        <button class="btn_3" id='add-<?php echo $product->id ?>'>add to cart</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!--================End Single Product Area =================-->
    </main>

<?php include_once "./components/footer.php" ?>

<script>
    let id = '<?php echo $product->id ?>'
    let in_cart = check_product(id)
    if (in_cart)
        switch_text(id, in_cart)
</script>