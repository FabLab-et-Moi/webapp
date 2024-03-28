<?php
// Inclure le fichier de configuration de la base de données
include('configusr.php');

// Vérifier si le paramètre 'motd' a été envoyé via POST
if (isset($_POST['activity'])) {
    // Échapper les caractères spéciaux pour des raisons de sécurité
    $newActivity = mysqli_real_escape_string($link, $_POST['activity']);

    // Requête SQL pour mettre à jour le MOTD dans la table infofablab
    $sql = "UPDATE infofablab SET activity = '$newActivity'";
    $result = mysqli_query($link, $sql);

    if ($result) {
        // En cas de succès, renvoyer une réponse JSON indiquant le succès
        echo json_encode(['success' => true]);
    } else {
        // En cas d'erreur, renvoyer une réponse JSON avec un message d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du MOTD.']);
    }
} else {
    // Si le paramètre 'motd' n'a pas été envoyé, renvoyer une réponse JSON avec un message d'erreur
    echo json_encode(['success' => false, 'message' => 'Paramètre "motd" manquant.']);
}

// Fermer la connexion à la base de données
mysqli_close($link);
?>
