<?php
include('../server/user.php');
session_start();
$error = deleteUserById($_SESSION['userid']);
if (empty($error)) {
    $_SESSION = array();
    session_destroy();
    header("Location: ../index.php");
} else {
    echo $error;
}
