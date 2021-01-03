<?php
session_start();
$_SESSION = array(); // Sessionarray wird neu gesetzt
session_destroy();
header("Location: ../index.php"); // Weiterleitung auf index.php
?>