<?php
if (empty($_GET["id"])) {
    header("Location: /");
    exit();
}

if (!is_numeric($_GET["id"])) {
    header("Location: /");
}

$config = require("Utilities/Helpers/Configuration.php");
require("App/Model/Products.php");

$db = new Products($config["Database"], "root", "Ayman_Database");
$row = $db->GetAllProducts("SingleByID", $_GET["id"]);

if (!$row) {
    header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="icon" type="image/x-icon" href="Utilities/Images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <img src="Uploads/<?= htmlspecialchars($row["Image"]) ?>" alt="Product Image" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">

                <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                    <h5 class="mb-0"><?= htmlspecialchars($row["Name"]) ?></h5>

                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $row["ID"] ?>">
                        <button type="submit" class="btn btn-primary">Add to Shopping Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>