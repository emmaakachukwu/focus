<?php
$title = "Home | Products";
$header_title = 'Welcome to Focus Shop..';
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
        <?php include_once "./components/page_header.php"; ?>
        <section class="popular-items latest-padding">
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
                                                    <img src="assets/img/gallery/popular1.png" alt="">
                                                    <div class="img-cap">
                                                        <span>Add to cart</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="popular-caption">
                                                    <h3><?php echo $product->name ?></h3>
                                                    <span>product name</span>
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

<?php include_once "./components/footer.php";