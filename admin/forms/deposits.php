<?php

include "./../lib/config.php";

if ( !isset($post['deposit_id']) || empty(trim($post['deposit_id'])) || !isset($post['approved']) || empty(trim($post['approved'])) || !is_numeric($post['deposit_id']) )
    array_push($errors, 'something went wrong.. refresh');
else {
    $pid = $post['deposit_id'];
    $approved = $post['approved'];
}

if ( $approved == 'true' )
    $approved = true;
else if ( $approved == 'false' )
    $approved = false;
else
    array_push($errors, 'something went wrong.. refresh');

check_errors($errors);

$at = date('Y-m-d H:i:s');
$approved_at = $approved ? null : $at;
$sql = $link->prepare("UPDATE `deposits` SET `approved_at`=?, `updated_at`=? WHERE id=?");
$sql->bind_param("ssi", $approved_at, $at, $pid);
if ( $sql->execute() ) {
    $_SESSION['success'] = $approved ? ["Deposit UnApproved"] : ['Deposit Approved'];
    $sql->close();
    on_success('deposits');
}

array_push($errors, 'Something went wrong; retry.. '.$link->error);

check_errors($errors);