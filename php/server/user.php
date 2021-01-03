<?php
function createUser($user)
{
    // Database connection
    include('sqlConnection.php');

    $errorString = '';

    $letterOnly = "/^[a-zA-Z]+$/i";
    $passwordPattern = "/^[ -~]+$/";

    // Validation of userid
    // not empty
    // length: 3-20
    // only letters($letterOnly regex)
    $trimmedUserId = trim($user["userid"]);
    if (
        !empty($trimmedUserId) &&
        strlen($trimmedUserId) >= 3 && strlen($trimmedUserId) <= 20 &&
        preg_match($letterOnly, $trimmedUserId)
    ) {
        $userid = htmlentities($trimmedUserId);
    } else {
        $errorString .= "Invalid userid\n";
    }

    // Validation of name
    // not empty
    // length: 3-45
    $trimmedName = trim($user["name"]);
    if (
        !empty($trimmedName) &&
        strlen($trimmedName) >= 3 && strlen($trimmedName) <= 45
    ) {
        $name = htmlentities($trimmedName);
    } else {
        $errorString .= "Invalid name\n";
    }

    // Validation of email
    // not empty
    // length: 1-100
    $trimmedEmail = trim($user["email"]);
    if (
        !empty($trimmedEmail) &&
        strlen($trimmedEmail) >= 1 && strlen($trimmedEmail) <= 100
    ) {
        $email = htmlentities($trimmedEmail);
    } else {
        $errorString .= "Invalid email\n";
    }

    // Validation of password
    // not empty
    // length: 8-255
    if (
        !empty($user["password"]) &&
        strlen($user["password"]) >= 8 && strlen($user["password"]) <= 255 &&
        preg_match($passwordPattern, $user["password"])
    ) {
        $password = htmlentities($user["password"]);
    } else {
        $errorString .= "Invalid password\n";
    }

    if (empty($errorString)) {
        $query = "SELECT * FROM user where userid=? LIMIT 1";
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $userid);

        $stmt->execute();

        $result = $stmt->get_result();

        $firstRow = $result->fetch_row();

        if (isset($firstRow)) {
            $errorString .= "User already exists\n";
        }
    }

    if (empty($errorString)) {
        // INPUT Query erstellen
        $query = "INSERT INTO user(userid, name, email, password) VALUES (?,?,?,?)";
        // Query vorbereiten mit prepare();
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $errorString .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden mit bind_param();
        $hashedPW = password_hash($password, PASSWORD_BCRYPT);
        if (!$stmt->bind_param('ssss', $userid, $name, $email, $hashedPW)) {
            $errorString .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        // query ausführen mit execute();
        if (!$stmt->execute()) {
            $errorString .= 'execute() failed ' . $mysqli->error . '<br />';
        }
        // Verbindung schliessen
        $stmt->close();
    }

    return $errorString;
}

function loginUser($loginUser)
{
    // Database connection
    include('sqlConnection.php');

    $errorString = '';

    // validate userid
    if (isset($loginUser['userid'])) {
        //trim
        $userid = trim($loginUser['userid']);
    } else {
        $errorString .= "Please provide a userid";
    }

    // validate password
    if (isset($loginUser['password'])) {
        //trim
        $password = trim($loginUser['password']);
    } else {
        $errorString .= "Please provide a password";
    }

    if (empty($errorString)) {

        $query = "SELECT * FROM user where userid=? LIMIT 1";
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $userid);

        $stmt->execute();

        $result = $stmt->get_result();

        $firstRow = $result->fetch_assoc();

        if (!isset($firstRow)) {
            $errorString .= "Invalid userid or password";
        }

        if (empty($errorString)) {
            if (password_verify($password, $firstRow['password'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $firstRow['userid'];
                $_SESSION['name'] = $firstRow['name'];
                $_SESSION['email'] = $firstRow['email'];
                session_regenerate_id();
            }

            if (!isset($_SESSION['loggedin']) or isset($_SESSION['loggedin']) and !$_SESSION['loggedin']) {
                $errorString .= "Invalid userid or password";
            }
        }

        $result->free();
    }

    return $errorString;
}
function editUser($userid, $user)
{
    // Database connection
    include('sqlConnection.php');

    $errorString = '';

    $letterOnly = "/^[a-zA-Z]+$/i";
    $passwordPattern = "/^[ -~]+$/";

    // Validation of name
    // not empty
    // length: 3-45
    $trimmedName = trim($user["name"]);
    if (
        !empty($trimmedName) &&
        strlen($trimmedName) >= 3 && strlen($trimmedName) <= 45
    ) {
        $name = htmlentities($trimmedName);
    } else {
        $errorString .= "Invalid name\n";
    }

    // Validation of email
    // not empty
    // length: 1-100
    $trimmedEmail = trim($user["email"]);
    if (
        !empty($trimmedEmail) &&
        strlen($trimmedEmail) >= 1 && strlen($trimmedEmail) <= 100
    ) {
        $email = htmlentities($trimmedEmail);
    } else {
        $errorString .= "Invalid email\n";
    }

    if (empty($errorString)) {
        // INPUT Query erstellen
        $query = "UPDATE user SET name = ?, email = ? where userid = ?";
        // Query vorbereiten mit prepare();
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $errorString .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden mit bind_param();
        if (!$stmt->bind_param('sss', $name, $email, $userid)) {
            $errorString .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        // query ausführen mit execute();
        if (!$stmt->execute()) {
            $errorString .= 'execute() failed ' . $mysqli->error . '<br />';
        }

        if (empty($errorString)) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            session_regenerate_id();
        }
        // Verbindung schliessen
        $stmt->close();
    }

    return $errorString;
}
function changeUserPassword($userid, $user)
{
    // Database connection
    include('sqlConnection.php');

    $passwordPattern = "/^[ -~]+$/";

    $errorString = '';

    // validate password
    if (isset($user['oldPassword'])) {
        //trim
        $oldPassword = $user['oldPassword'];
    } else {
        $errorString .= "Please provide your old password";
    }

    // Validation of password
    // not empty
    // length: 8-255
    if (
        !empty($user["password"]) &&
        strlen($user["password"]) >= 8 && strlen($user["password"]) <= 255 &&
        preg_match($passwordPattern, $user["password"])
    ) {
        $password = $user["password"];
    } else {
        $errorString .= "Invalid password\n";
    }

    if (empty($errorString)) {

        $query = "SELECT * FROM user where userid=? LIMIT 1";
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $userid);

        $stmt->execute();

        $result = $stmt->get_result();

        $firstRow = $result->fetch_assoc();

        if (!isset($firstRow)) {
            $errorString .= "Invalid userid";
        }

        if (empty($errorString)) {
            if (!password_verify($oldPassword, $firstRow['password'])) {
                $errorString .= "Invalid old Password";
            } else {
                // INPUT Query erstellen
                $query = "UPDATE user SET password = ? where userid = ?";
                // Query vorbereiten mit prepare();
                $stmt = $mysqli->prepare($query);
                if ($stmt === false) {
                    $errorString .= 'prepare() failed ' . $mysqli->error . '<br />';
                }
                // Parameter an Query binden mit bind_param();
                $hashedPW = password_hash($password, PASSWORD_BCRYPT);
                if (!$stmt->bind_param('ss', $hashedPW, $userid)) {
                    $errorString .= 'bind_param() failed ' . $mysqli->error . '<br />';
                }
                // query ausführen mit execute();
                if (!$stmt->execute()) {
                    $errorString .= 'execute() failed ' . $mysqli->error . '<br />';
                }

                if (empty($errorString)) {
                    session_regenerate_id();
                }
                // Verbindung schliessen
                $stmt->close();
            }
        }

        $result->free();
    }
    return $errorString;
}
function deleteUserById($userid)
{
    // Database connection
    include('sqlConnection.php');

    $errorString = '';
    // SELECT Query erstellen
    $query = "DELETE FROM user WHERE userid = ?";
    // Query vorbereiten mit prepare();
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        $errorString .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    // Parameter an Query binden mit bind_param();
    if (!$stmt->bind_param('s', $userid)) {
        $errorString .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }
    // query ausführen mit execute();
    if (!$stmt->execute()) {
        $errorString .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    // Verbindung schliessen
    $stmt->close();

    return $errorString;
}
function logoutUser()
{
    session_start();
    $_SESSION = array();
    session_destroy();
}
