<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
include('configusr.php');
include('variableAndFunctions.php');

// Récupérer le statut d'ouverture du FabLab depuis la base de données
$sql = "SELECT ouverture FROM infofablab";
$result = mysqli_query($link, $sql);

// Vérifier s'il y a des résultats
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $ouverture = $row["ouverture"];
} else {
    // Si aucune donnée n'est disponible, par défaut, considérer que le FabLab est fermé
    $ouverture = 0;
}

// Définir la classe Bootstrap pour le badge en fonction du statut d'ouverture
$badge_class = ($ouverture == 1) ? 'bg-success' : 'bg-danger';
$ouverture_text = ($ouverture == 1) ? 'Ouvert' : 'Fermé';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>FabLab & Moi | <?php echo htmlspecialchars($_SESSION["username"]); ?></title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }

        .navbar {
            margin-bottom: 20px;
        }

    </style>
</head>

<body>

    <nav class="navbar navbar-light bg-light" id="navbarNavDropdown">
        <div class="container-fluid">
            <a class="navbar-brand">Mon espace FabLab & Moi</a>
            <form class="d-flex">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Mon Compte
            </a>
            <ul class="dropdown-menu" >
                <li><a class="dropdown-item" href="#"></a><?php echo htmlspecialchars($_SESSION["username"]); ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item active" href="#">Mon Espace</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="reset-password.php">Changer mon mot de passe</a></li>
                <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
            </ul>
            </li>
                <a href="../index.php" class="btn btn-warning ml-3">Retour au site</a>
                <a href="logout.php" class="btn btn-danger ml-3">Déconnexion</a>
                
            </form>
        </div>
    </nav>

    <h1 class="my-5">Bonjour, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> et bienvenue dans votre espace FabLab.</h1>

    <div class="container">
        <div class="row">
            <!-- Mon FabLab -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/placeholder.jpg" class="card-img-top" alt="Image du FabLab">
                    <div class="card-body">
                        <h5 class="card-title">Mon FabLab</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Ouverture
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $ouverture_text; ?></span>
                            </li>
                            <!-- Ajoutez d'autres éléments de liste si nécessaire -->
                        </ul>
                        <!-- Ajoutez ici d'autres informations sur le FabLab si nécessaire -->
                        <a href="#" class="btn btn-primary mt-3">En savoir plus</a>
                    </div>
                </div>
            </div>
            <!-- Mes Projets -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mes Projets</h5>
                        <p class="card-text">Contenu de la catégorie "Mes Projets" avec des projets récents.</p>
                        <a href="#" class="btn btn-primary">Voir mes projets</a>
                    </div>
                </div>
            </div>
            <!-- Mes Compétences -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mes Compétences</h5>
                        <p class="card-text">Contenu de la catégorie "Mes Compétences" avec les compétences du compte.</p>
                        <a href="#" class="btn btn-primary">Voir mes compétences</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
