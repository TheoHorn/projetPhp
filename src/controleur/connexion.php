<?php
if (isset($_POST['submit']) && $_POST['submit'] = 'Valider'){
    if((isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['password']) && !empty($_POST['password']))){
        header("Location: VueMembre/");
    } else {
        echo '<script type="text/javascript">window.alert("Veuillez saisir tous les champs");</script>';
    }
}