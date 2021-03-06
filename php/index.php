<?php
// Datei einbinden mit den Notizen
include('./server/note.php');
session_start();

// Filter für die Notes welche bei Done auf 0 gesetzt sind
function openFilter($note)
{
    return $note[3] === 0;
}
// Filter für die Notes welche bei Done auf 1 gesetzt sind
function doneFilter($note)
{
    return $note[3] === 1;
}

if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
    // Abfrage aller Notizen aufgrund der userid
    $notes = getNotesByUserId($_SESSION["userid"]);
    // Abspeichern aller Notizen welche bei Done auf 0 gesetzt sind
    $openNotes = array_filter($notes, 'openFilter');
    // Abspeichern aller Notizen welche bei Done auf 1 gesetzt sind
    $doneNotes = array_filter($notes, 'doneFilter');
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nokes | Home</title>
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
    <div class="container mt-4">
        <?php
        // Falls eine Session vorhanden ist Container und Titel hinzufügen
        if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
            echo <<<EOT
                <h2>Open</h2>
                <div class="container">
                    <div class="row">
            EOT;
            // Jede Notiz welche bei done auf 0 gesetzt ist als Card hinzufügen
            foreach ($openNotes as $note) {
                echo <<<EOT
                    <div class="col-sm">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{$note[1]}</h5>
                                <p class="card-text">{$note[2]}</p>
                                <a class="btn btn-success" href="./helperPages/markNoteAsDone.php?id={$note[0]}" role="button">Done</a>
                                <a class="btn btn-primary" href="detail.php?id={$note[0]}" role="button">Detail</a>
                                <a class="btn btn-danger" href="./helperPages/deleteNote.php?id={$note[0]}" role="button">Delete</a>
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
            // Jede Notiz welche bei done auf 1  gesetzt ist als Card hinzufügen
            foreach ($doneNotes as $note) {
                echo <<<EOT
                    <div class="col-sm">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{$note[1]}</h5>
                                <p class="card-text">{$note[2]}</p>
                            </div>
                            <a class="btn btn-danger" href="./helperPages/deleteNote.php?id={$note[0]}" role="button">Delete</a>
                        </div>
                    </div>
                    EOT;
            };
            echo <<<EOT
                </div>
                    </div>
            EOT;
            // Falls keine Session vorhanden ist Meldung anzeigen
        } else {
            echo <<<EOT
                <div class="alert alert-warning" role="alert">Login or register to use Nokes</div>
            EOT;
        };
        ?>
    </div>

    <!-- Einbindung der Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>

</html>