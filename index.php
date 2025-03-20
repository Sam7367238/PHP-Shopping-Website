<?php

require("Utilities/Helpers/Database.php");

$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$routes = [
    "/" => "App/View/index.php",
    "/register" => "App/View/Authentication/Register.php",
    "/login" => "App/View/Authentication/Login.php",
    "/logout" => "App/Helpers/Logout.php",
    "/new" => "App/View/Upload/NewProduct.php",
    "/product" => "App/View/Upload/ViewProduct.php",
    "/cart" => "App/View/Other/Cart.php",
    "/order" => "App/View/Download/Order.php",
    "/success" => "App/View/Other/Success.php",
    "/orders" => "App/View/Download/Orders.php",
    "/clientorder" => "App/View/Download/ViewOrder.php"
];

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    include("App/View/Errors/NotFound.php");
    die();
}