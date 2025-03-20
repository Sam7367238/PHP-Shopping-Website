<?php
session_start();
require("Utilities/Middleware/LoggedIn.php");
require("App/Controller/Cart.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="icon" type="image/x-icon" href="Utilities/Images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("Utilities/Includes/NavBar.php") ?>

    <ul class="list-group">
    <?php foreach ($items as $item) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong><?= htmlspecialchars($item["Name"]) ?></strong> 
                <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($item["Quantity"]) ?></span>
                <span class="badge bg-secondary rounded-pill">$<?= number_format(htmlspecialchars($item["Product_Price"]), 2) ?></span>
            </div>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item["Product_ID"]) ?>">
                <input type="hidden" name="owner_id" value="<?= htmlspecialchars($item["Owner_ID"]) ?>">
                <input type="submit" class="btn btn-danger btn-sm" name="deleteCart" value="Delete">
            </form>
        </li>
    <?php endforeach; ?>

    <?php if (count($items) < 1) : ?>
        <li class="list-group-item text-center">
            <p class="mb-0">Your cart is empty.</p>
        </li>
    <?php else : ?>
        <li class="list-group-item text-center">
            <a href="/order" class="btn btn-success">Order</a>
        </li>
    <?php endif; ?>
</ul>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>