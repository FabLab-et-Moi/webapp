<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(403);
    exit;
}

include('configusr.php');

// Récupérer le statut d'ouverture actuel
$sql = "SELECT ouverture FROM infofablab";
$result = mysqli_query($link, $sql);

if (!$result) {
    $response = array(
        'success' => false
    );
} else {
    $row = mysqli_fetch_assoc($result);
    $ouverture = $row["ouverture"];

    // Mettre à jour le statut d'ouverture
    $new_ouverture = ($ouverture == 1) ? 0 : 1;
    $update_sql = "UPDATE infofablab SET ouverture = $new_ouverture";
    $update_result = mysqli_query($link, $update_sql);

    if (!$update_result) {
        $response = array(
            'success' => false
        );
    } else {
        // Préparer la réponse pour JavaScript
        $badge_class = ($new_ouverture == 1) ? 'bg-success' : 'bg-danger';
        $ouverture_text = ($new_ouverture == 1) ? 'Ouvert' : 'Fermé';
        $response = array(
            'success' => true,
            'badge_class' => $badge_class,
            'ouverture_text' => $ouverture_text
        );
    }
}

// Retourner la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>