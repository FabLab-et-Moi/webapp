<?php
session_start();
 
// On deconnecte l'utilisateur car sinon y'a une faille de sécurité
$_SESSION = array();
// Verification de si l'utilisateur est déjà conencté, si oui on le redirige vers la page de bienvenue
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
 

// Importation du fichier de configuration
require_once "configusr.php";
 

// On definie les variables et on les initialise avec des valeurs vide
$username = $password = "";
$username_err = $password_err = $login_err = "";
 

// Traitement des données quand le formulaire est envoyé 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    // On verifie si le username est vide
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    

    // On vérifie si le mot de passe est vide
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    

    // On verifie les données 
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            header("location: dashboard.php");
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
 
    <!-- En-tête de la page -->
 
    <meta charset="UTF-8">
    <title>Admin. FabLab</title>
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
                <a class="navbar-brand">FabLab & Moi (Admin)</a>
                <form class="d-flex">
                <a href="../index.php" class="btn btn-danger ml-3">Annuler</a>
                </form>
            </div>
            </nav>
    
    <!-- Login form / Formulaire de connection -->
    <div class="d-flex flex-column justify-content-center w-100 h-100">
    <div class="d-flex flex-colimn justify-content-center align-items-center">
    <div class="wrapper">
        <h2>Connexion Administrateur</h2>
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
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
    </div>
    </div>
</body>
</html>
