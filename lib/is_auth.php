<?php

require_once "./lib/config.php";

if ( is_logged_in() ) {
    header('location: ./index.php');
    die();
}