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


// Récupérer le MOTD depuis la base de données
$sql_motd = "SELECT motd FROM infofablab";
$result_motd = mysqli_query($link, $sql_motd);

// Vérifier s'il y a des résultats
if (mysqli_num_rows($result_motd) > 0) {
    $row_motd = mysqli_fetch_assoc($result_motd);
    $motd = $row_motd["motd"];
} else {
    // Si aucun MOTD n'est disponible, laisser la variable $motd vide
    $motd = "Aucun message du jour";
}


// Récupérer l'activité depuis la base de données
$sql_activity = "SELECT activity FROM infofablab";
$result_activity = mysqli_query($link, $sql_activity);

// Vérifier s'il y a des résultats
if (mysqli_num_rows($result_activity) > 0) {
    $row_activity = mysqli_fetch_assoc($result_activity);
    $activity = $row_activity["activity"];
} else {
    // Si aucune activité n'est disponible
    $activity = "Aucune activité";
}
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
            <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Mon Compte
            </button>
            <ul class="dropdown-menu" >
                <li><a class="dropdown-item" href="#"></a> <?php echo htmlspecialchars($_SESSION["username"]); ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item active" href="#">Mon Espace</a></li>
                <li><a class="dropdown-item disabled" href="#">Mes Projets</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#infoModal">Informations</a></li>
                <li><a class="dropdown-item" href="reset-password.php">Changer mon mot de passe</a></li>
                <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
            </ul>
            </li>
                <a href="../index.php" class="btn btn-warning ml-3">Retour au site</a>
               <!-- <a href="logout.php" class="btn btn-danger ml-3">Déconnexion</a> -->
                
            </form>
        </div>
    </nav>
    
    <!-- MOTD -->
    <div class="alert alert-secondary alert-dismissible fade show" role="alert"><?php echo $motd;?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>

    <h1 class="my-5">Bonjour, <b><?php echo htmlspecialchars($_SESSION["username"]); ?> </b> et bienvenue dans votre espace FabLab.</h1>

    <div class="container">
        <div class="row">
            <!-- Mon FabLab -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/placeholder.jpg" class="card-img-top ratio-21x9" alt="Image du FabLab">
                    <div class="card-body">
                        <h5 class="card-title">Mon FabLab</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Ouverture
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $ouverture_text; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Activité
                                <span class="badge bg-secondary"><?php echo $activity; ?></span>
                            </li>
                            <!-- Ajoutez d'autres éléments de liste si nécessaire -->
                        </ul>
                        <!-- Ajoutez ici d'autres informations sur le FabLab si nécessaire -->
                        <a href="#" class="btn btn-success mt-3">J'y suis!</a>
                        <a href="#" class="btn btn-primary mt-3">En savoir plus</a>
                        <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#horairesModal">Horaires</a>
                    </div>
                </div>
            </div>

            <!-- Modal pour les horaires -->
            <div class="modal fade" id="horairesModal" tabindex="-1" aria-labelledby="horairesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="horairesModalLabel">Horaires du FabLab</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Insérer ici les horaires récupérés depuis la base de données -->
                            <?php
                            // Récupérer les horaires du FabLab depuis la base de données
                            $sql_horaires = "SELECT horaires FROM infofablab";
                            $result_horaires = mysqli_query($link, $sql_horaires);

                            // Vérifier s'il y a des résultats
                            if (mysqli_num_rows($result_horaires) > 0) {
                                $row_horaires = mysqli_fetch_assoc($result_horaires);
                                $horaires = $row_horaires["horaires"];
                                echo "<p>" . $horaires . "</p>";
                            } else {
                                echo "<p>Aucun horaire disponible pour le moment.</p>";
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Modal info -->
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="infoModalLabel">FabLab & Moi (ver 2024.01a)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>Changelog:</h3>
                            <ul>
                            <li><b>Version initiale</b></li>
                            <p>Toutes les fonctionalités initialement prévu sont disponible.</p>
                            <li><b>Ajout de la fonctionalité "J'y suis!"</b></li>
                            <p>Cette fonctionalité permet de savoir qui est actuellement présent au FabLab, la liste se réinitialise toutes les 1h.</p>
                            </ul>
                            

                            <h3>Crédits:</h3>
                            <p>Codée par Enzo DURAN (T-NSI23/24), Luigi Dupont Gallon (T-NSI23/24) et Pauline Labadie (T-NSI23/24)</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
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
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Design 3D
                                <span class="badge bg-success">Niveau 1</span>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                Programmation Python
                                <span class="badge bg-success">Niveau 2</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Découpe Laser
                                <span class="badge bg-success">Niveau 1</span>
                            </li>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-primary">Modifier mes compétences</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
