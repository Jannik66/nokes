<?php
function createNote($note)
{
    // Database connection
    include('sqlConnection.php');

    $errorString = '';

    $id = uniqid();

    // Validation of title
    // not empty
    // length: 1-50
    // only letters($letterOnly regex)
    $trimmedTitle = trim($note["title"]);
    if (
        !empty($trimmedTitle) &&
        strlen($trimmedTitle) >= 1 && strlen($trimmedTitle) <= 50
    ) {
        $title = htmlentities($trimmedTitle);
    } else {
        $errorString .= "Invalid title\n";
    }

    // Validation of content
    // not empty
    // length: 1-500
    $trimmedContent = trim($note["content"]);
    if (
        !empty($trimmedContent) &&
        strlen($trimmedContent) >= 1 && strlen($trimmedContent) <= 500
    ) {
        $content = htmlentities($trimmedContent);
    } else {
        $errorString .= "Invalid name\n";
    }

    // Validation of userid
    // not empty
    if (
        !empty($note["userid"])
    ) {
        $userid = htmlentities($note["userid"]);
    } else {
        $errorString .= "Invalid user\n";
    }

    if (empty($errorString)) {
        // INPUT Query erstellen
        $query = "INSERT INTO note(id, title, content, fk_userid) VALUES (?,?,?,?)";
        // Query vorbereiten mit prepare();
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $errorString .= 'prepare() failed ' . $mysqli->errorString . '<br />';
        }
        // Parameter an Query binden mit bind_param();
        if (!$stmt->bind_param('ssss', $id, $title, $content, $userid)) {
            $errorString .= 'bind_param() failed ' . $mysqli->errorString . '<br />';
        }
        // query ausführen mit execute();
        if (!$stmt->execute()) {
            $errorString .= 'execute() failed ' . $mysqli->errorString . '<br />';
        }
        // Verbindung schliessen
        $stmt->close();
    }

    // TODO handle error string
    //echo "ErrorString:";
    //echo $errorString;
}
function getNotesByUser()
{
    // Database connection
    include('sqlConnection.php');

    session_start();

    $userid = $_SESSION["userid"];
    // SELECT Query erstellen
    $query = "SELECT * FROM note WHERE fk_userid = ?";
    // Query vorbereiten mit prepare();
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        $errorString .= 'prepare() failed ' . $mysqli->errorString . '<br />';
    }
    // Parameter an Query binden mit bind_param();
    if (!$stmt->bind_param('s', $userid)) {
        $errorString .= 'bind_param() failed ' . $mysqli->errorString . '<br />';
    }
    // query ausführen mit execute();
    if (!$stmt->execute()) {
        $errorString .= 'execute() failed ' . $mysqli->errorString . '<br />';
    }
    // Verbindung schliessen
    $notes = $stmt->get_result();
    $stmt->close();

    // TODO handle error string
    //echo "ErrorString:";
    //echo $errorString;
    return $notes;
}
