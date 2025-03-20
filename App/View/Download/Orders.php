<?php
require("App/Controller/Orders.php");

require("App/Model/Users.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Users($config["Database"], "root", "Ayman_Database");
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
        <h2 class="mb-4">Orders</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php if ($rows !== "None") : ?>
                        <th>Order ID</th>
                        <th>Country</th>
                        <th>City/State/District</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Buyer</th>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($rows !== "None") : ?>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row["ID"]) ?></td>
                            <td><?= htmlspecialchars($row["Country"]) ?></td>
                            <td><?= htmlspecialchars($row["Address1"]) ?></td>
                            <td><?= htmlspecialchars($row["Address2"]) ?></td>
                            <td><?= htmlspecialchars($row["Phone_Number"]) ?></td>
                            <td><?= htmlspecialchars($db -> GetAllUsers("ByID", null, $row["Buyer_ID"])["Username"]) ?></td>
                            <td>
                                <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" style="display:inline;">
                                    <input type="hidden" name="Order_ID" value="<?= htmlspecialchars($row["ID"]) ?>">
                                    <input type="submit" class="btn btn-success btn-sm" value="Mark Completed" name="completeOrder" id="completeOrder">
                                </form>
                                <a href="/clientorder?id=<?= htmlspecialchars($row["ID"]) ?>" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="mb-0 text-center fs-4">No orders incoming from your sold products.</p>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>