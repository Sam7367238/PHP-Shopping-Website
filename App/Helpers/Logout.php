<?php

if (!file_exists("App/View/index.php")) {
    header("Location: /");
    exit();
}

session_start();

if (isset($_SESSION["User"])) {
    session_destroy();
    header("Location: /");
    exit();
} else {
    header("Location: /");
    exit();
}