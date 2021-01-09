<?php

require_once "./../lib/config.php";

if ( !is_logged_in() ) {
    logout();
} else {
    $uuid = $_SESSION['uuid'];
}

$sql = "SELECT * FROM users WHERE uuid = '$uuid' LIMIT 1";
$result = $link->query($sql);
if ( $result->num_rows ) {
    $user = $result->fetch_object();
} else {
    logout(false);
}

validate_empty_fields($post);

if ( !isset($_FILES['file']) || empty(trim($_FILES['file']['name'])) )
    array_push($errors, 'Please select a file for upload');

check_errors($errors);

$target_dir = "./../uploads/proofs/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$newFileName = md5($uuid.time()).'.'.$imageFileType;
$path = $target_dir.$newFileName;
$imageSize = $_FILES['file']['size'];
$allowed = ['jpg', 'png', 'jpeg', 'gif'];

if ( !isset($imageFileType) || !$imageFileType || !in_array($imageFileType, $allowed) ) {
    array_push($errors, 'File type not allowed; allowed file types: '.implode(', ', $allowed));
}
if ( !getimagesize($_FILES["file"]["tmp_name"]) ) {
    array_push($errors, 'File is not a valid image file');
}
if ( $imageSize > 500000 ) {
    array_push($errors, 'File is larger than 500KB');
}
check_errors($errors);

if ( !move_uploaded_file($_FILES["file"]["tmp_name"], $path) ) {
    array_push($errors, 'File upload error; retry');
}
check_errors($errors);

$at = date('Y-m-d H:i:s');
$sql = $link->prepare("INSERT INTO `deposits` (`user_id`, amount, image_path, created_at) VALUES (?, ?, ?, ?)");
$sql->bind_param("siss", $user->id, $amount, $newFileName, $at);
if ( $sql->execute() ) {
    $sql->close();
    $_SESSION['success'] = ['Deposit submitted; pending approval by admin'];
    on_success('deposit');
}
$sql->close();

array_push($errors, 'Something went wrong; retry.. '.$link->error);

check_errors($errors);