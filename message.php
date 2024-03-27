<?php
if (!isset($_SESSION)) {
    session_start();
}
include('config.php');
include('variableAndFunctions.php');

function escape_for_display($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Fonction pour vérifier si le User-Agent est celui d'un navigateur
function is_browser_user_agent() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $allowed_user_agents = array('Mozilla', 'Chrome', 'Safari', 'Opera', 'Edge');

    foreach ($allowed_user_agents as $allowed_agent) {
        if (stripos($user_agent, $allowed_agent) !== false) {
            return true;
        }
    }

    return false;
}

if (isset($_POST['action']) and $_POST['action'] == 'sendmessage') {
    // Vérification du User-Agent
    if (!is_browser_user_agent()) {
        $_SESSION['msg'] = "Accès non autorisé!";
        redirect('/index.php');
        exit;
    }

      // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['msg'] = "Accès non autorisé (CSRF)!";
        redirect('/index.php');
        exit;
    }

    $name = escape_for_display($_POST['name']);
    $message = escape_for_display($_POST['message']);
    $verification = ($_POST['verification']);
    $timedate = escape_for_display(date("Y-m-d H:i:s"));

    // obtient l'ip du gadjo
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // obtient l'useragent du gadjo
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Vérification du calcul de la vérification
    $expected_verification = $previousSumRandNum; 

    if (empty($name) || empty($message) || empty($verification) || $verification != $expected_verification) {
        $_SESSION['msg'] = "Vérif échouée!";
        redirect('/index.php');
    } else {
        $stmt = $dbconnect->prepare("INSERT INTO `$dbname`.`$tablename` (`id`, `name`, `message`, `date`, `ip_address`, `user_agent`) VALUES (NULL, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $message, $timedate, $ip_address, $user_agent);
        $sendMessage = $stmt->execute();

        if ($sendMessage) {
            $_SESSION['msg'] = "Message Ajouté!";
            unset($_SESSION['sumRandNum']);
            redirect('/index.php');
        } else {
            $_SESSION['msg'] = "Echec de l'envoi!";
            unset($_SESSION['sumRandNum']);
            redirect('/index.php');
            exit;
        }
    }
} else {
    unset($_SESSION['sumRandNum']);
    redirect('/index.php');
}
?>
