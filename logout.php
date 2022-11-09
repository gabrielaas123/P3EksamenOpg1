<?php
// Start en session 
session_start();
 
//Her omsætter den alt den indtastede data 
$_SESSION = array();
 
// Nu destruerer den sessionen
session_destroy();
 
// Til sidst redirgerer den brugeren tilbage til login.php siden
header("location: login.php");
exit;
?>

