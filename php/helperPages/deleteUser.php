<?php
include('../server/user.php'); // Datei einbinden mit der Funktion User löschen
session_start();
$error = deleteUserById($_SESSION['userid']); // Aufruf der deleteUserById Funktion mit mitgegebenen Parameter
if (empty($error)) {
    $_SESSION = array(); // Sessionarray wird neu gesetzt
    session_destroy();
    header("Location: ../index.php"); // Bei Erfolg Weiterleitung auf index.php
} else {
    echo $error; // bei nicht Erfolg Ausgabe des Fehlers
}
