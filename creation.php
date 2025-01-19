<?php
        include ("cnx.php");
        $cnx -> query("insert into client values('".$_POST["id"]."','".$_POST["nom"]."','".$_POST["prenom"]."','".$_POST["email"]."','".$_POST["mdp"]."')");
        $sql = "SELECT * FROM client WHERE email = '$email'";
        $result = $cnx->query($sql);

    if ($result->num_rows > 0) {
        
        echo "<script>
                alert('Email déjà existant.');
                window.location.href = 'index.php'; // Redirection vers la page actuelle
              </script>";
        exit();
    }
    ?>

