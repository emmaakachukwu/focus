<?php

include "./../lib/config.php";

if ( !isset($post['pid']) || empty(trim($post['pid'])) || !is_numeric($post['pid']) )
    array_push($errors, 'something went wrong.. refresh');
else
    $pid = $post['pid'];

check_errors($errors);

$at = date('Y-m-d H:i:s');
$sql = $link->prepare("UPDATE `products` SET `deleted_at`=? WHERE id=?");
$sql->bind_param("si", $at, $pid);
if ( $sql->execute() ) {
    $_SESSION['success'] = ['Product Deleted'];
    $sql->close();
    on_success('products');
}

array_push($errors, 'Something went wrong; retry.. '.$link->error);

check_errors($errors);