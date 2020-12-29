<?php

$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` varchar(100) NOT NULL PRIMARY KEY,
    `email` varchar(100) NOT NULL,
    `username` varchar(100) NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'user',
    `password` varchar(250) NOT NULL,
    `fname` varchar(100) DEFAULT NULL,
    `lname` varchar(100) DEFAULT NULL,
    `country` varchar(100) DEFAULT NULL,
    `state` varchar(100) DEFAULT NULL,
    `city` varchar(100) DEFAULT NULL,
    `phone` varchar(20) DEFAULT NULL,
    `image_path` varchar(250) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
$link->query($sql);

$admin_email = 'admin@crestminers.com';
$id = md5($admin_email . '...');
$sql = "SELECT id FROM users WHERE id = '$id' LIMIT 1";
$result = $link->query($sql);
if ( !$result->num_rows ) {
    $sql = "INSERT INTO users (id, username, email, fname, lname, password, role) VALUES ('$id', 'crestminersadmin', '$admin_email', 'crest', 'miners', 'crestpass100', 'admin')";
    $link->query($sql);
}

/*** FOR TOKENS ***/
$sql = "CREATE TABLE IF NOT EXISTS `tokens` (
        `id` INT(100) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `token` varchar(250) NOT NULL,
        `user_id` varchar(100) DEFAULT NULL,
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        `type` INT(10) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
";
$link->query($sql);

/*** FOR REQUESTS ***/
$sql = "CREATE TABLE IF NOT EXISTS `requests` (
        `id` INT(100) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `requested_by` varchar(100) NOT NULL,
        FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        `type` INT(10) NOT NULL,
        `approved` bool NOT NULL DEFAULT FALSE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
";
$link->query($sql);