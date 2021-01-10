<?php

if ( isset($_GET['delivered']) ) {
    $is_delivered = $_GET['delivered'];
    if ( $is_delivered == 'true' ) {
        $is_delivered = true;
    } else if ( $is_delivered == 'false' ) {
        $is_delivered = false;
    }
}

$is_delivered = $is_delivered ?? false;
$prefix = $is_delivered ? 'Delivered' : 'UnDelivered';
$title = $prefix.' Orders';
require_once "./components/nav.php";

$sql = !$is_delivered ? "SELECT o.*, u.username, p.name, p.image_path FROM orders AS o LEFT JOIN users AS u ON o.user_id = u.id LEFT JOIN products AS p ON o.product_id = p.id WHERE delivered_at IS NULL ORDER BY o.created_at DESC" : "SELECT o.*, u.username, p.name, p.image_path FROM orders AS o LEFT JOIN users AS u ON o.user_id = u.id LEFT JOIN products AS p ON o.product_id = p.id WHERE delivered_at IS NOT NULL ORDER BY o.created_at DESC";
$result = $link->query($sql);
$orders = [];
if ( $result->num_rows ) {
    while($res = $result->fetch_object())
        array_push($orders, $res);
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

<div class="card-box pd-20 height-100-p mb-30">
    <table class="table table-responsive">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Order ID</th>
            <th scope="col">Ordered By</th>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Status</th>
            <th scope="col">Ordered On</th>
            <?php if ($is_delivered) echo "<th scope='col'>Delivered At</th>" ?>
            <th scope="col">Actions</th>
        </thead>
        <?php if ( count($orders) ) { ?>
            <tbody>
                <?php for ( $i = 0; $i < count($orders); $i++ ) { ?>
                    <tr>
                        <td><?php echo  $i+1 ?></td>
                        <td>
                            <?php if ( isset($orders[$i]->image_path) ) { ?>
                                <img src="./../uploads/products/<?php echo $orders[$i]->image_path ?>" alt="<?php echo $orders[$i]->name ?>" class="image-fluid table-image">
                            <?php } ?>
                        </td>
                        <td><?php echo $orders[$i]->order_id ?></td>
                        <td><?php echo $orders[$i]->username ?></td>
                        <td><?php echo $orders[$i]->name ?></td>
                        <td><?php echo $orders[$i]->quantity ?></td>
                        <td><span class="text-muted"><?php echo $orders[$i]->paid ? 'Paid' : 'Not Paid' ?></span></td>
                        <td><?php echo date('d M, Y h:i a', strtotime($orders[$i]->created_at)) ?? '' ?></td>
                        <?php if ($is_delivered) { ?>
                            <td><?php echo date('d M, Y h:i a', strtotime($orders[$i]->delivered_at)) ?? '' ?></td>
                        <?php } ?>
                        <td>
                            <button type='button' class="btn btn-primary btn-sm" onclick="deliver('<?php echo $orders[$i]->id ?>')">Mark as <?php echo $is_delivered ? 'not' : '' ?> delivered</button>
                            <form action="./forms/orders.php<?php echo !empty($_GET) ? '?'.http_build_query($_GET) : '' ?>" class="d-inline" id="form-<?php echo $orders[$i]->id ?>" method='post'>
                                <input type="hidden" name='order_id' value="<?php echo $orders[$i]->id ?>">
                                <input type="hidden" name='delivered' value="<?php echo $is_delivered ? 'true' : 'false' ?>">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>					
</div>

<?php include_once "./components/auth_footer.php" ?>

<script>
    const deliver = (id) => {
        let form = document.querySelector('#form-'+id)
        if ( confirm("Mark as <?php echo !$is_delivered ? '' : 'not' ?> delivered?") )
            form.submit();
    }
</script>