<?php
// Datei einbinden mit der Funktion User löschen
include('../server/user.php'); 
session_start();
// Aufruf der deleteUserById Funktion mit mitgegebenen Parameter
$error = deleteUserById($_SESSION['userid']); 
if (empty($error)) {
    // Sessionarray wird neu gesetzt
    $_SESSION = array(); 
    session_destroy();
    // Bei Erfolg Weiterleitung auf index.php
    header("Location: ../index.php"); 
} else {
    // bei nicht Erfolg Ausgabe des Fehlers
    echo $error; 
}
