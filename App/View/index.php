<?php

require("App/Model/Users.php");
require("App/Controller/Products.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Users($config["Database"], "root", "Ayman_Database");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RubyStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="Utilities/Images/Logo.png">
</head>
<body>
    <?php include("Utilities/Includes/NavBar.php"); ?>

    <div class="container mt-5">
        <?php if (!empty($result)) : ?>
            <div class="alert alert-primary">
                <p><?= htmlspecialchars($result) ?></p>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php foreach ($products as $product) : ?>
                <?php $rows = $db -> GetAllUsers("ByID", null, $product["Seller_ID"]) ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card shadow-sm">
                        <img src="Uploads/<?= htmlspecialchars($product["Image"]) ?>" class="card-img-top img-fluid" alt="Product Image" style="width: 100%; height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($product["Name"]) ?></h5>
                            <p class="card-text">$<?= htmlspecialchars(number_format($product["Price"], 2)) ?> | @<?= $rows["Username"] ?></p>

                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="d-flex gap-2 justify-content-center">
                                <input type="hidden" name="productID" value="<?= $product["ID"] ?>">
                                <input type="submit" class="btn btn-primary" name="addCart" value="Add To Cart">
                            </form>

                            <?php if (!empty($_SESSION["User"])) : ?>
                                <?php if ($_SESSION["User"]["UserID"] === $rows["ID"]) : ?>
                                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="d-flex gap-2 justify-content-center mt-2">
                                        <input type="hidden" name="productID" value="<?= $product["ID"] ?>">
                                        <input type="hidden" name="sellerID" value="<?= $product["Seller_ID"] ?>">
                                        <input type="submit" class="btn btn-danger" name="deleteProduct" value="Delete">
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>