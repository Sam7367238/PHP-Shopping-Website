<?php

if (!isset($_SESSION["User"])) {
    require("App/View/Errors/Unauthorized.php");
    exit();
}