<?php
$id = $_GET['id'];
include('../server/note.php');
session_start();
$error = markNoteAsDone($id, $_SESSION['userid']);
if (empty($error)) {
    header("Location: ../index.php");
} else {
    echo $error;
}
