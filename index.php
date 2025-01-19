<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<link rel="stylesheet" href="login.css">

<form method="POST" id="login_form" >
        <fieldset>
            <legend>Login</legend>
            <table>
                <tr>
                    <td>Email: </td>
                    <td><input type="text" name="email" placeholder="Enter Email" required></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="mdp" placeholder="Enter Password" required></td>
                </tr>
            </table>
            <button type="submit">LOGIN</button>
            <br>
            <p>Don't have an account? <a href="creation.html">Register</a></p>
        </fieldset>
    </form>
    <?php
    include("cnx.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $sql = "select * from client WHERE email = '$Email' AND mdp = '$mdp' ";
    $result=$cnx->query($sql);
    if ($result->num_rows > 0) {
        header("Location: reservation.php");
        exit;
    } else {
        echo "<p style='color:red;'>Email ou mot de passe incorrect.</p>";
    }
}
$cnx->close();
    ?>
</body>
</html>