<?php

if (empty($_GET["id"])) {
    header("Location: /orders");
}

if (!is_numeric($_GET["id"])) {
    header("Location: /orders");
}

require("App/Controller/Orders.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="Utilities/Images/Logo.png">
</head>
<body class="bg-light">

    <?php include("Utilities/Includes/NavBar.php"); ?>

    <div class="container mt-5">
        <a href="/orders" class="btn btn-primary mb-3">Go Back</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rowsProducts as $product) : ?>
                    <tr>
                        <td><?= htmlspecialchars($product["ID"]) ?></td>
                        <td><?= htmlspecialchars($product["Product_Name"]) ?></td>
                        <td><?= htmlspecialchars($product["Quantity"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>