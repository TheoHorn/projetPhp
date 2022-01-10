<h1>Connection<h1>

        <form method="post" action="">
            <p>Nom</p>
            <input type="text" name="nom" required>
            <p>Password</p>
            <input type="password" name="password" required>
            <input type="submit" name="connection" value="Valider">
        </form>


<?php

use wishlist\controleur\Authentication;

require_once __DIR__ . '/src/vendor/autoload.php';

\wishlist\conf\Database::connect();

if(isset($_SESSION)) {
    header('location:./');
} else {
    if(isset($_POST['connection'])) {
        Authentication::authenticate($_POST['nom'], $_POST['password']);
        header('location:./');
    }
}
