<?php
// Initialize the session
// Initialisaition de la session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// Verification de si l'utilisateur est déjà conencté, si oui on le redirige vers la page de bienvenue
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
 
// Include config file
// Importation du fichier de configuration
require_once "configusr.php";
 
// Define variables and initialize with empty values
// On definie les variables et on les initialise avec des valeurs vide
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
// Traitement des données quand le formulaire est envoyé 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    // On verifie si le username est vide
    if(empty(trim($_POST["username"]))){
        $username_err = "Veuillez entrer votre identifiant.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    // On vérifie si le mot de passe est vide
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    // On verifie les données 
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: dashboard.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Vos informations de connexion sont incorrecte.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
 
    <!-- En-tête de la page -->
 
    <meta charset="UTF-8">
    <title>FabLab & Moi | Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/login.css" rel="stylesheet">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>

    <!-- Navigation bar / Barre de navigation -->
 
    <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">FabLab de Champollion</a>
                <form class="d-flex">
                <a href="../index.php" class="btn btn-danger ml-3">Retour</a>
                </form>
            </div>
            </nav>
    
    <!-- Login form / Formulaire de connection -->
    <div class="d-flex flex-column justify-content-center w-100 h-100">
    <div class="d-flex flex-colimn justify-content-center align-items-center">
    <div class="wrapper">
        <h2>Connexion élève</h2>
        <p></p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Connexion">
            </div>
            <p>Pas de compte? <a href="register.php">Créer un compte maintenant</a>.</p>
        </form>
    </div>
    </div>
    </div>
</body>
</html>
