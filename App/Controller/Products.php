<?php
session_start();

require("App/Model/Products.php");
require("App/Model/Cart.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Products($config["Database"], "root", "Ayman_Database");
$cartDB = new Cart($config["Database"], "root", "Ayman_Database");

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$products = $db -> GetAllProducts();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["createProduct"])) {
        require("Utilities/Middleware/LoggedIn.php");
        
        $errors = [];

        $productName = filter_input(INPUT_POST, "productName", FILTER_SANITIZE_SPECIAL_CHARS);
        $productPrice = filter_input(INPUT_POST, "productPrice", FILTER_SANITIZE_NUMBER_INT);

        if (empty($productName) || empty($productPrice)) {
            array_push($errors, "All fields are required.");
        }

        if (!isset($_FILES['productImage']) || $_FILES['productImage']['error'] !== UPLOAD_ERR_OK) {
            array_push($errors, "Please provide an image.");
        } else {
            $fileTmpPath = $_FILES['productImage']['tmp_name'];
            $fileName = basename($_FILES['productImage']['name']);
            $fileSize = $_FILES['productImage']['size'];
            $fileType = $_FILES['productImage']['type'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowedTypes)) {
                array_push($errors, "Incorrect file type. Allowed: JPG, PNG, GIF.");
            }

            $newFileName = uniqid() . '.' . $fileExt;
            $destPath = "Uploads/" . $newFileName;
        }

        if (empty($errors)) {
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $db -> NewProduct($productName, $productPrice, $newFileName, $_SESSION["User"]["UserID"]);
                header("Location: /");
            }
        }
    } elseif (!empty($_POST["addCart"])) {
        if (empty($_SESSION["User"])) {
            $result = "You must be logged in to order.";
        } elseif ($_SESSION["User"]) {
            $cartDB -> AddToCart($_SESSION["User"]["UserID"], $_POST["productID"]);
            $result = "Added to cart";
        }
    } elseif (!empty($_POST["deleteProduct"])) {
        require("Utilities/Middleware/LoggedIn.php");

        $id = $_POST["productID"];

        if ($_SESSION["User"]["UserID"] == $_POST["sellerID"]) {
            $db -> VoidProduct($id);
            header("Location: /");
        }
    }
}