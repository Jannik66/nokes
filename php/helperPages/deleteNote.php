<?php
$id = $_GET['id']; // GET-Abfrage auf mitgegebene ID
include('../server/note.php'); // Datei einbinden mit der Funktion Notiz löschen
session_start(); 
$error = deleteNoteById($id, $_SESSION['userid']); // Aufruf der deleteNoteById Funktion mit mitgegebenen Parameter
if (empty($error)) {
    header("Location: ../index.php"); // Bei Erfolg Weiterleitung auf index.php
} else {
    echo $error; // bei nicht Erfolg Ausgabe des Fehlers
}
