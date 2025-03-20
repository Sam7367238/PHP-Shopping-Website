<?php
session_start();
require("Utilities/Middleware/LoggedIn.php");

require("App/Model/Orders.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Orders($config["Database"], "root", "Ayman_Database");

$rows = $db -> GetOrdersForSeller($_SESSION["User"]["UserID"]);

if (!empty($_GET["id"])) {
    $orderResult = $db -> ValidateOrderByID($_GET["id"], $_SESSION["User"]["UserID"]);

    if ($orderResult == "Not Found") {
        header("Location: /orders");
    } elseif ($orderResult == "Found") {
        $rowsProducts = $db -> GetOrderProductsForOrder($_GET["id"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (count($rows) < 1) {
        return;
    }

    if (!empty($_POST["completeOrder"])) {
        $db -> VoidOrder($_POST["Order_ID"]);
        header("Location: /orders");
    }
}