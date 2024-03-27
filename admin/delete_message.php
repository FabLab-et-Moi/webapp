<?php
session_start();
include('config.php');


    $messageId = $_POST['message_id'];
    $deleteQuery = "DELETE FROM `$dbname`.`$tablename` WHERE id = $messageId";
    mysqli_query($dbconnect, $deleteQuery);
    $_SESSION['msg'] = "Message deleted successfully.";

header("Location: welcome.php"); // Redirect back to your main page
exit();
?>
