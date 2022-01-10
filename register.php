<div align="center">
    <h2>Inscription</h2>
    <br><br><br>
    <form method="post" action="">
        <table>
            <tr>
                <td>
                    <label>Identifiant :</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre identifiant" name="identifiant" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" name="password" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Confirmer votre mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" name="reppassword" required>
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" name="inscription" value="Je m\'incsris"/>
    </form>
</div>

<?php

use wishlist\controleur\Authentication;

require_once __DIR__ . '/src/vendor/autoload.php';

\wishlist\conf\Database::connect();

if(isset($_POST['inscription'])) {
    if($_POST['password'] == $_POST['reppassword']) {
        Authentication::createUser($_POST['identifiant'],$_POST['password']);
        header('location:./login.php');
    } else {
        echo 'Les mots de passe ne correspondent pas';
    }
}

