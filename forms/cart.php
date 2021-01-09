<?php

require_once "./../lib/config.php";

if ( !is_logged_in() ) {
    $_GET['to_checkout'] = 'true';
    on_success('login');
} else {
    on_success('checkout');
}