<?php
include('./server/note.php');
session_start();
if (empty($_SESSION['loggedin'])) {
    header("Location: index.php");
}

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
    <title>Nokes | New Note</title>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    include('./helperPages/navbar.php');
    ?>
    <div class="container col-4 mt-5">
        <h1>Create Note</h1>

        <?php
        // Ausgabe der Fehlermeldungen
        if (strlen($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }
        ?>
        <form action="./create.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" maxLength="50" required />
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5" cols="50" maxLength="500" required></textarea>
            </div>

            <input type="hidden" name="userid" value="<?php echo $_SESSION['userid'] ?>" />

            <div class="d-grid mt-4">
                <button class="btn btn-dark" type="submit" name="button" value="submit">Submit</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>


</html>