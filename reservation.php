<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Vols</title>
    
</head>
<body>
    <link rel="stylesheet" href="reservation.css">
    <form method="post" action="vol.php">
    <!--<input type="hidden" name="idclient" value=" //echo htmlspecialchars($idclient); ?>">-->
    <?php
         
         include("cnx.php");
         session_start();
 
         

         if (!isset($_SESSION["idclient"])) {
            echo "Identifiant client non trouvé. Veuillez vous connecter.";
            exit();
        }
        
        $idclient = $_SESSION["idclient"];
 
         
         $sql = "SELECT nom, prenom FROM client WHERE idclient = '$idclient'";
         $result = $cnx->query($sql);
 
         if ($result->num_rows > 0) {
             $row = $result->fetch_assoc();
             $_SESSION["nom"] = $row["nom"];
             $_SESSION["prenom"] = $row["prenom"];
             echo "<p>Bonjour : " . htmlspecialchars($row["nom"]) . " " . htmlspecialchars($row["prenom"]) . "</p>";
         } else {
             echo "<p>Client non trouvé.</p>";
             exit;
         }
 
         $result->close();
        //session_destroy();
    ?>
    <h1>Liste des Vols</h1>
    <table>
        <thead>
            <tr>
                <th>NOM VOL</th>
                <th>VILLE DEPART</th>
                <th>VILLE ARRIVEE</th>
                <th>DATE VOL</th>
                <th>SÉLECTION</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //session_start(); 
            include "cnx.php";
            
            if (!isset($_SESSION["idclient"])) {
                
                header("Location: login.php");
                exit;
            }
            $idclient = $_SESSION["idclient"];
            $req = "SELECT idvol, nomvol, villdep, villariv, datevol FROM vol"; 
            $res = $cnx->query($req); 

            if ($res && ($res->num_rows) > 0) { 
                while ($row = $res->fetch_assoc()) { 
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["nomvol"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["villdep"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["villariv"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["datevol"]) . "</td>";
                    echo "<td class='checkbox-column'><input type='checkbox' name='vols[]' value='" . htmlspecialchars( $row['idvol']) . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Aucun vol trouvé</td></tr>";
            }
            
        //}
            ?>
        </tbody>
    </table>
            
    <button type="submit" >Réserver les vols sélectionnés</button>
    </form>
</body>
</html>
