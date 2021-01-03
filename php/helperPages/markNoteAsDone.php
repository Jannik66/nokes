<?php
// GET-Abfrage auf mitgegebene ID
$id = $_GET['id']; 
// Datei einbinden mit der Funktion Notiz auf Done stellen
include('../server/note.php');  
session_start();
// Aufruf der markNoteAsDone Funktion mit mitgegebenen Parameter
$error = markNoteAsDone($id, $_SESSION['userid']);  
if (empty($error)) {
    // Bei Erfolg Weiterleitung auf index.php
    header("Location: ../index.php"); 
} else {
    // bei nicht Erfolg Ausgabe des Fehlers
    echo $error; 
}
