<?php
session_start();
// remove all session variables$email=$_SESSION['Email'];
$email=$_SESSION['Email'];
if((!isset($email)))
{
    echo '<script>alert("Session not Set")</script>';
    header("Location: SuperUserLogin.php");
}
session_unset();

// destroy the session
session_destroy(); 
header("Location: SuperUserLogin.php");
?>