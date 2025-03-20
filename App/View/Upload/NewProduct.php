<?php
require("App/Controller/Products.php");

require("Utilities/Middleware/LoggedIn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="Utilities/Images/Logo.png">
</head>
<body class="bg-light">

    <?php include("Utilities/Includes/NavBar.php"); ?>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Create Product</h2>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <p class="mb-1"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($result)) : ?>
                <div class="alert alert-success">
                    <p><?= htmlspecialchars($result) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="productName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="productName" name="productName"
                        value="<?= !empty($_POST["productName"]) ? htmlspecialchars($_POST["productName"]) : "" ?>" required>
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Price</label>
                    <input type="number" class="form-control" id="productPrice" name="productPrice" required
                        value="<?= !empty($_POST["productPrice"]) ? htmlspecialchars($_POST["productPrice"]) : "" ?>">
                </div>

                <div class="mb-3">
                    <label for="productImage" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" required>
                </div>

                <input type="submit" class="btn btn-primary w-100" name="createProduct" id="createProduct" value="Create Product">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>