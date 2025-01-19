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

    // Vérifiez si des vols ont été sélectionnés
    if (isset($_POST['vols']) && is_array($_POST['vols']) && count($_POST['vols']) > 0) {
        $vols = $_POST['vols']; // Tableau contenant les IDs des vols sélectionnés

        // Convertir les IDs en une chaîne pour la requête SQL
        $ids = implode(',', array_map('intval', $vols));

        // Requête pour récupérer les informations des vols sélectionnés
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
    // Vérification si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['siege'])) {
        // Récupération des valeurs du formulaire
        $siege = htmlspecialchars($_POST['siege']);  // Siège sélectionné
        $status = 'En cours';  // Le statut est "En cours"
        $date_confirmation = date("Y-m-d");  // La date de confirmation est la date actuelle

        // Récupération de l'ID du client (ici, fixé à 1 pour l'exemple)
        $client_id = 1;

        // Récupération des vols sélectionnés
        if (isset($_POST['vols']) && is_array($_POST['vols']) && count($_POST['vols']) > 0) {
            $vols = $_POST['vols']; // Tableau contenant les IDs des vols sélectionnés

            // Insertion des réservations dans la table reservation pour chaque vol sélectionné
            foreach ($vols as $idvol) {
                // Préparer la requête pour insérer la réservation
                $req = "INSERT INTO reservation (siege, status, datereservation, idclient, idvol) 
                        VALUES ('$siege', '$status', '$date_confirmation', '$client_id', '$idvol')";
                
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