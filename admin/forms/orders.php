<?php

include "./../lib/config.php";

if ( !isset($post['order_id']) || empty(trim($post['order_id'])) || !isset($post['delivered']) || empty(trim($post['delivered'])) || !is_numeric($post['order_id']) )
    array_push($errors, 'something went wrong.. refresh');
else {
    $oid = $post['order_id'];
    $delivered = $post['delivered'];
}

if ( $delivered == 'true' )
    $delivered = true;
else if ( $delivered == 'false' )
    $delivered = false;
else
    array_push($errors, 'something went wrong.. refresh');

check_errors($errors);

$at = date('Y-m-d H:i:s');
$delivered_at = $delivered ? null : $at;
$sql = $link->prepare("UPDATE `orders` SET `delivered_at`=?, `updated_at`=? WHERE id=?");
$sql->bind_param("ssi", $delivered_at, $at, $oid);
if ( $sql->execute() ) {
    $_SESSION['success'] = $delivered ? ["Order Undelivered"] : ['Order Delivered'];
    $sql->close();
    on_success('orders');
}

array_push($errors, 'Something went wrong; retry.. '.$link->error);

check_errors($errors);