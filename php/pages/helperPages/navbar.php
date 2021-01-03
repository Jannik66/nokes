<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">Nokes</a>
        <div class="d-flex justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
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