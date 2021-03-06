<?php
// Datei einbinden mit der Funktion loginUser
include('./server/user.php');
$error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
   // Aufruf der loginUser Funktion mit den Parameter
  $error = loginUser($_POST);
  // Bei Erfolg Weiterleitung auf index.php
  if (empty($error)) {
    header("Location: index.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nokes | Login</title>
  <!-- Icon für die Webseite -->
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php
  // Einbindung der Navbar
  include('./helperPages/navbar.php');
  ?>
  <?php
  // Ausgabe der Fehlermeldungen
  if (strlen($error)) {
    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
  }
  ?>
  <div class="container col-4 mt-5">
    <h1>Login</h1>
    <!-- Formular für POST -->
    <form action="./login.php" method="post">
      <div class="form-group ">
        <label for="userid">Username</label>
        <!-- required setzen -->
        <input type="text" name="userid" class="form-control" id="userid" value="" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <!-- required setzen -->
        <input type="password" name="password" class="form-control" id="password" required />
      </div>
      <div class="d-grid mt-4">
        <!-- Hinzufügen des Submitbuttons -->
        <button class="btn btn-dark" type="submit" name="button" value="submit">Submit</button>
      </div>
    </form>
  </div>
  <!-- Einbindung der Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>

</html>