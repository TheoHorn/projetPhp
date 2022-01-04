<?php

require_once './vendor/autoload.php';
require_once './conf/Database.php';

use wishlist\model\Item;
use wishlist\conf\Database;

try {
    $token = password_hash('Max_monz55',PASSWORD_DEFAULT, ['cost'=>12]);
    echo "token : " . $token .
        "\n";
    if(password_verify('Max_monz55', $token)) {
        echo 'mot de passe verifier';
    }
} catch (Exception $e) {
}
