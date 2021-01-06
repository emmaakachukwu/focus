<?php

require_once "./../lib/functions.php";

if ( !isset($_SESSION['uuid']) || empty($_SESSION['uuid']) )
    logout();
else
    on_success('checkout');