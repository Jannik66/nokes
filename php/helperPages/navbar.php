<!-- Navbar mit Bootstrap Attributen -->
<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
    <!-- Container für die Inhalte der Navbar -->
    <div class="container-fluid">
        <!-- Einfügen des Titels und des Logos als Verlinkung auf index.php -->
        <a class="navbar-brand" href="./index.php"><img src="./assets/logo.png" height="50" width="50" alt="Lunaka" />Nokes</a>
        <div class="d-flex justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                // Falls eine Session vorhanden ist werden die Elemente für die Nutzung des Tools angezeigt
                if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
                    echo <<<EOT
                        <li class="nav-item">
                            <a class="nav-link" href="./create.php">New Note</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {$_SESSION['userid']}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
                                <li><a class="dropdown-item" href="./changePw.php">Change PW</a></li>
                                <li><a class="dropdown-item" href="./helperPages/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    EOT;
                    // Falls keine Session vorhanden ist werden die Anmeldung und Registrierung angezeigt
                } else {
                    echo <<<EOT
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./register.php">Register</a>
                    </li>
                    EOT;
                }
                ?>
            </ul>
        </div>
    </div>
</nav>