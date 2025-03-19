<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vols Sélectionnés</title>
    <link rel="stylesheet" href="vol.css">
</head>
<body>
    <h1 style="text-align: center;">Vols Sélectionnés</h1>

    <?php
    include "cnx.php";
    session_start();
    /*$idc = $_POST['idvol']
    $idv = array();
    foreach($_POST['vols'] as $val){
        $idv[] = $val;
    }
    $nbv = count($idv);*/

    
    if (isset($_POST['vols']) && is_array($_POST['vols']) && count($_POST['vols']) > 0) {
        $vols = $_POST['vols']; 
        $ids = implode(',', array_map('intval', $vols));
        $req = "SELECT nomvol, villdep, villariv, datevol FROM vol WHERE idvol IN ($ids)";
        $res = $cnx->query($req);

        if ($res && ($res->num_rows > 0)) {
            echo '<table>';
            echo '<thead><tr><th>Nom Vol</th><th>Ville Départ</th><th>Ville Arrivée</th><th>Date Vol</th></tr></thead>';
            echo '<tbody>';

            while ($row = $res->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['nomvol']) . '</td>';
                echo '<td>' . htmlspecialchars($row['villdep']) . '</td>';
                echo '<td>' . htmlspecialchars($row['villariv']) . '</td>';
                echo '<td>' . htmlspecialchars($row['datevol']) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p class="info">Aucun vol trouvé pour les IDs sélectionnés.</p>';
        }
    } else {
        echo '<p class="info">Aucun vol sélectionné. Veuillez revenir à la liste des vols.</p>';
    }
    ?>

    <form method="post">
        
        <?php
        if (isset($_POST['vols']) && is_array($_POST['vols'])) {
            foreach ($_POST['vols'] as $idvol) {
                echo '<input type="hidden" name="vols[]" value="' . htmlspecialchars($idvol) . '">';
            }
        }
        ?>

        <label>Numéro de Siège : </label>
        <input type="text" name="siege" id="siege" placeholder="Exemple: A12" required>
        
        <label>Status : </label>
        <input type="text" value="En cours" readonly>
        
        <label>Date de confirmation :</label>
        <input type="text" id="dt" readonly>
        <script>
            const today = new Date();
            const date = today.toISOString().split('T')[0];
            document.getElementById("dt").value = date;
        </script>
        
        <button type="submit">Confirmer</button>
    </form>

    <?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['siege'])) {
        
        $siege = htmlspecialchars($_POST['siege']);  
        $status = 'En cours';  
        $date_confirmation = date("Y-m-d");  

        
        $idclient = $_SESSION["idclient"];
        

        
        if (isset($_POST['vols']) && is_array($_POST['vols']) && count($_POST['vols']) > 0) {
            $vols = $_POST['vols']; 

            
            foreach ($vols as $idvol) {
                
                $req = "INSERT INTO reservation (siege, status, datereservation, idclient, idvol) 
                        VALUES ('$siege', '$status', '$date_confirmation', '$idclient', '$idvol')";
                
                if ($cnx->query($req) === TRUE) {
                    echo "<p>Réservation réussie pour le vol $idvol.</p>";
                } else {
                    echo "<p>Erreur : " . $cnx->error . "</p>";
                }
            }
        } else {
            echo "<p>Aucun vol sélectionné.</p>";
        }
    }

    ?>
</body>
</html>