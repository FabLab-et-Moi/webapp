<?php
// Inclure le fichier de configuration de la base de données
include('configusr.php');

// Requête SQL pour récupérer le MOTD depuis la table infofablab
$sql = "SELECT activity FROM infofablab";
$result = mysqli_query($link, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $activity = $row['activity'];
    echo $activity;
} else {
    // En cas d'erreur, renvoyer un message d'erreur
    echo "Erreur lors de la récupération de l'activité.";
}

// Fermer la connexion à la base de données
mysqli_close($link);
?>
