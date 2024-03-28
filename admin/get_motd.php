<?php
// Inclure le fichier de configuration de la base de données
include('configusr.php');

// Requête SQL pour récupérer le MOTD depuis la table infofablab
$sql = "SELECT motd FROM infofablab";
$result = mysqli_query($link, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $motd = $row['motd'];
    echo $motd;
} else {
    // En cas d'erreur, renvoyer un message d'erreur
    echo "Erreur lors de la récupération du MOTD.";
}

// Fermer la connexion à la base de données
mysqli_close($link);
?>
