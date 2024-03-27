<?php
if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Génère un jeton CSRF de 32 octets
}

include('config.php');
include('variableAndFunctions.php');
?>

<!-- Coucou a toi, si tu regarde le code source hesite pas a venir parler sur insta :) @iamenzobeth -->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://castorisdead.xyz/assets/images/avatar/avatar.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="https://castorisdead.xyz/assets/images/avatar/avatar.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title><?= $title ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FabLab & Moi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Acceuil</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Autre Lycées
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item active" href="#">Champollion (Lattes)</a></li>
                <li><a class="dropdown-item" href="#">Comming soon!</a></li>
            </ul>
            </li>
            <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Connexion Admin.</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light border border-primary" href="eleve/login.php">Connexion élève</a>
                    </li>
                </ul>
            </div>
    </div>
</nav>

<div class="gradient-bg">
        <div class="centered">
            <h1>FabLab & Moi</h1>
            <p class="slogan">Il n'a jamais été aussi simple d'avoir des idées</p>

</body>

</html>
<?php
// Close the connection
mysqli_close($dbconnect); 
?>