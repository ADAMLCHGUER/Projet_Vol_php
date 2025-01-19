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
    <input type="hidden" name="idclient" value="<?php echo htmlspecialchars($idclient); ?>">
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
            include "cnx.php"; 
            $req = "SELECT idvol, nomvol, villdep, villariv, datevol FROM vol"; 
            $res = $cnx->query($req); 

            if ($res && ($res->num_rows) > 0) { 
                while ($row = $res->fetch_assoc()) { 
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["nomvol"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["villdep"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["villariv"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["datevol"]) . "</td>";
                    echo "<td class='checkbox-column'><input type='checkbox' name='vols[]' value='" . htmlspecialchars($row['idvol']) . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Aucun vol trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <button type="submit" >Réserver les vols sélectionnés</button>
    </form>
</body>
</html>
