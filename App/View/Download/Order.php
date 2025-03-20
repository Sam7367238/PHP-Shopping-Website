<?php
session_start();

require("Utilities/Middleware/LoggedIn.php");
require("App/Controller/Order.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="Utilities/Images/Logo.png">
</head>
<body class="bg-light">

    <?php include("Utilities/Includes/NavBar.php"); ?>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Order</h2>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <p class="mb-1"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="<?= !empty($_POST["country"]) ? htmlspecialchars($_POST["country"]) : "" ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address1" class="form-label">City/State/District</label>
                    <input type="text" class="form-control" id="address1" name="address1"
                        value="<?= !empty($_POST["address1"]) ? htmlspecialchars($_POST["address1"]) : "" ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address2" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address2" name="address2"
                        value="<?= !empty($_POST["address2"]) ? htmlspecialchars($_POST["address2"]) : "" ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber"
                        value="<?= !empty($_POST["phoneNumber"]) ? htmlspecialchars($_POST["phoneNumber"]) : "" ?>" required>
                </div>
                
                <input type="submit" class="btn btn-primary w-100" name="orderlocation" id="orderlocation" value="Confirm Location">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>