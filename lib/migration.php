<?php

$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
    `balance` int(50) DEFAULT 0,
    `image_path` varchar(250) DEFAULT NULL,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL
)";
$link->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `price` INT(50) NOT NULL,
    `desc` MEDIUMTEXT NULL,
    `formula` VARCHAR(50) NULL,
    `image_path` VARCHAR(100) NULL,
    `deleted_at` TIMESTAMP NULL,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL
)";
$link->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `payments` (
    `id` INT(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `amount` INT(50) NOT NULL,
    `image_path` VARCHAR(100) NOT NULL,
    `approved_at` TIMESTAMP NULL,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL
)";
$link->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS `wallets` (
    `id` INT(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `type` VARCHAR(50) NULL,
    `wallet_id` VARCHAR(100) NULL,
    `bank_name` VARCHAR(100) NULL,
    `bank_address` VARCHAR(200) NULL,
    `recipient_name` VARCHAR(100) NULL,
    `swift_code` VARCHAR(100) NULL,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL
)";
$link->query($sql);

$admin_email = 'admin@fadchemicals.com';
$sql = "SELECT email FROM users WHERE email = '$admin_email' LIMIT 1";
$result = $link->query($sql);
if ( !$result->num_rows ) {
    $sql = "INSERT INTO users (username, email, fname, lname, password, role) VALUES ('fadchemsadmin', '$admin_email', 'fad', 'chemicals', 'fadchemspass100', 'admin')";
    $link->query($sql);
}

$sql = "SELECT id FROM wallets LIMIT 1";
$result = $link->query($sql);
if ( !$result->num_rows ) {
    $sql = "INSERT INTO wallets (`type`, wallet_id, bank_name, bank_address, recipient_name, swift_code) VALUES
            ('btc', '1Mqkt6rMcYKBWvPd63V9ufFjUqc95ugw5y', null, null, null, null),
            ('bank', '40820810238116105689', 'Sberbank', 'Moscow, st.  Garibaldi, 36.117418', 'Denis Jonathan', 'SABRRUMM'),
            ('native_lang', '40820810238116105689', 'Сбербанк', 'г. Москва, ул. Гарибальди, д. 36,117418', 'Денис Джонатан', 'SABRRUMM')
        ";
    $link->query($sql);
}
