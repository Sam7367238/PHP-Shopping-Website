<?php
session_start();

use Stripe\Exception\ApiErrorException;

require("Utilities/Middleware/LoggedIn.php");
require("vendor/autoload.php");
require("App/Model/Cart.php");
require("App/Model/Orders.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Cart($config["Database"], "root", "Ayman_Database");
$ordersDB = new Orders($config["Database"], "root", "Ayman_Database");

$secretKey = $config["API"]["Stripe_Key"];

\Stripe\Stripe::setApiKey($secretKey);

if (!isset($_GET['session_id'])) {
    require("App/View/Errors/Unauthorized.php");
    exit();
} elseif (empty($_SESSION["Owner_ID"])) {
    require("App/View/Errors/Unauthorized.php");
    exit();
}

try {
    $session = \Stripe\Checkout\Session::retrieve($_GET["session_id"]);

    if ($session -> payment_status === "paid") {
        $location = $_SESSION["Location"];
        $items = $db -> GetAllOwnedProducts($_SESSION["Owner_ID"]);
        $id = $ordersDB -> CreateOrder($items[0]["Seller_ID"], $_SESSION["Owner_ID"], $location["Country"], $location["Address1"], $location["Address2"], $location["Phone_Number"]);

        foreach ($items as $item) {
            $ordersDB -> AddOrderProduct($item["Name"], $item["Quantity"], $id);
        }

        $db -> EmptyCart($_SESSION["Owner_ID"]);
        unset($_SESSION["Owner_ID"]);
        unset($location);
    }
} catch (ApiErrorException $e) {
    require("App/View/Errors/ServerError.php");
    exit();
}