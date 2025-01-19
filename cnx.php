<?php
    $serv="127.0.0.1";
    $user="root";
    $pass= "";
    $bd="gestion_vol";
    $cnx = new mysqli($serv,$user,$pass,$bd);
    if ($cnx->connect_error) {
        die("Probleme de connexion");
    }
?>