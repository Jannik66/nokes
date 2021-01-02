<?php
include('../server/note.php');
session_start();


function openFilter($note)
{
    return $note[3] === 0;
}
function doneFilter($note)
{
    return $note[3] === 1;
}

if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
    foreach (getNotesByUserId($_SESSION["userid"]) as $note) {
        if (array_key_exists($note[0], $_POST)) {
            markNoteAsDone($note[0], $_SESSION['userid']);
        }
    }
    $notes = getNotesByUserId($_SESSION["userid"]);
    $openNotes = array_filter($notes, 'openFilter');
    $doneNotes = array_filter($notes, 'doneFilter');
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>N O K E S</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Nokes</a>
            <div class="d-flex justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
                        echo <<<EOT
                        <li class="nav-item">
                        <a class="nav-link" href="create.php">New Note</a>
                    </li>
 <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
         {$_SESSION['userid']}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="settings.php">Settings</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
EOT;
                    } else {
                        echo <<<EOT
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
EOT;
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php
        if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
            echo <<<EOT
        <h2>Open</h2>
        <div class="container">
        <div class="row">
EOT;
            foreach ($openNotes as $note) {
                echo <<<EOT
                            <div class="col-sm">
                            <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">{$note[1]}</h5>
                            <p class="card-text">{$note[2]}</p>
                            <form method="post"> 
                            <input class="btn btn-primary" type="submit" name="{$note[0]}"
                                    class="button" value="Done" /> 
                            </form>
                            <a class="btn btn-primary" href="detail.php?id={$note[0]}" role="button">Detail</a>
                            </div>
                            </div>
                            </div>
                        EOT;
            }
            echo <<<EOT
                            </div>
                            </div>
                            <h2>Done</h2>
                            <div class="container">
                            <div class="row">

        EOT;

            foreach ($doneNotes as $note) {
                echo <<<EOT
                            <div class="col-sm">
                            <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">{$note[1]}</h5>
                            <p class="card-text">{$note[2]}</p>
                            <form method="post"> 
                            <input class="btn btn-primary" type="submit" name="{$note[0]}"
                                    class="button" value="Done" /> 
                            </form>
                            <a class="btn btn-primary" href="detail.php?id={$note[0]}" role="button">Detail</a>
                            </div>
                            </div>
                            </div>
                        EOT;
            };
        };


        ?>
    </div>
    </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>


</html>