<?php

require("App/Model/Cart.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Cart($config["Database"], "root", "Ayman_Database");

$items = $db -> GetAllOwnedProducts($_SESSION["User"]["UserID"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("Utilities/Middleware/LoggedIn.php");
    if (!empty($_POST["deleteCart"])) {
        $db -> RemoveFromCart($_POST["owner_id"], $_POST["item_id"]);
        $items = $db -> GetAllOwnedProducts($_SESSION["User"]["UserID"]);
    }
}