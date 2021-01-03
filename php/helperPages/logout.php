<?php
session_start();
// Sessionarray wird neu gesetzt
$_SESSION = array(); 
session_destroy();
// Weiterleitung auf index.php
header("Location: ../index.php"); 
?>