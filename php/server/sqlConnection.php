<?php
$host_sql = 'INSERT IP HERE'; // host
$username_sql = 'NokesUser'; // username
$password_sql = 'nokesUserP4ssw0rd'; // password
$database_sql = 'nokes'; // database

// mit Datenbank verbinden
$mysqli = new mysqli($host_sql, $username_sql, $password_sql, $database_sql);
// fehlermeldung, falls verbindung fehl schlägt.

if ($mysqli->connect_error) {

die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>