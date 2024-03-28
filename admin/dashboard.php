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
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>FabLab & Moi | <?php echo htmlspecialchars($_SESSION["username"]); ?></title>>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                        <h5 class="card-title">Info FabLab</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Ouverture
                                <span id="ouverture-badge" class="badge <?php echo $badge_class; ?>"><?php echo $ouverture_text; ?></span>
                            </li>
                        </ul>
                        <button id="toggle-ouverture" class="btn btn-primary mt-3">Basculer le statut d'ouverture</button>
                    </div>

                    <script>
                    $(document).ready(function() {
                        $('#toggle-ouverture').click(function() {
                            $.ajax({
                                url: 'toggle_ouverture.php',
                                type: 'POST',
                                success: function(response) {
                                    if (response.success) {
                                        $('#ouverture-badge').removeClass().addClass('badge ' + response.badge_class).text(response.ouverture_text);
                                    } else {
                                        alert('Une erreur s\'est produite lors de la mise à jour du statut d\'ouverture.');
                                    }
                                }
                            });
                        });
                    });
</script>
                </div>
            </div>


            <!-- Mes Projets -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Message du jour</h5>
                        <p class="card-text"><?php echo $motd; ?></p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editMotdModal">
                        Modifier le MOTD
                        </button>

                        <!-- Modal pour modifier le MOTD -->
                        <div class="modal fade" id="editMotdModal" tabindex="-1" aria-labelledby="editMotdModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMotdModalLabel">Modifier le MOTD</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulaire pour modifier le MOTD -->
                                        <form id="editMotdForm">
                                            <div class="mb-3">
                                                <label for="motdTextarea" class="form-label">Nouveau MOTD</label>
                                                <textarea class="form-control" id="motdTextarea" rows="3"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-primary" id="saveMotdBtn">Enregistrer les modifications</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                // Intercepter le clic sur le bouton "Modifier le MOTD"
                                $('#editMotdModal').on('show.bs.modal', function(event) {
                                    // Charger le MOTD actuel dans le formulaire
                                    $.ajax({
                                        url: 'get_motd.php', // Script PHP pour récupérer le MOTD depuis la base de données
                                        type: 'GET',
                                        success: function(response) {
                                            $('#motdTextarea').val(response);
                                        },
                                        error: function() {
                                            alert('Une erreur s\'est produite lors du chargement du MOTD.');
                                        }
                                    });
                                });

                                // Intercepter le clic sur le bouton "Enregistrer les modifications"
                                $('#saveMotdBtn').click(function() {
                                    var newMotd = $('#motdTextarea').val();
                                    $.ajax({
                                        url: 'update_motd.php', // Script PHP pour mettre à jour le MOTD dans la base de données
                                        type: 'POST',
                                        data: {
                                            motd: newMotd
                                        },
                                        success: function(response) {
                                            $('#editMotdModal').modal('hide');
                                            // Actualiser la page ou effectuer d'autres actions après la mise à jour du MOTD
                                        },
                                        error: function() {
                                            alert('Une erreur s\'est produite lors de la mise à jour du MOTD.');
                                        }
                                    });
                                });
                            });
                        </script>
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
