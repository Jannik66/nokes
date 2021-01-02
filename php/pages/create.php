<?php
include('../server/note.php');
include('../server/user.php');
session_start();
$error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $error = createNote($_POST);
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
    <title>Nokes</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container col-4 mt-5">
        <h1>Create Note</h1>

        <?php
        // Ausgabe der Fehlermeldungen
        if (strlen($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }


        if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
            echo <<<EOT
    <form action ="" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" required/>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="title" class ="form-control" rows = "5" cols = "50" name = "description"></textarea>
        </div>      
        
        <input type="hidden" name="userid" value="{$_SESSION['userid']}" />

        <div class="d-grid mt-4">
        <button class="btn btn-dark type="submit" name="button" value="submit">Submit</button>
    </form>
    </div>
 EOT;
        } elseif (empty($_SESSION['loggedin'])) {
            header("Location: index.php");
        }
        ?>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

</html>