<?php
/* Database connection */
/* informations de connection a la BDD */
define('DB_SERVER', 'localhost:8889');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'fablabtest');
 
/* Attempt to connect database */
/* Tentative de connection a la BDD */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
// Verification de la connection 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
