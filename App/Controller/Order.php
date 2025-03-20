<?php

require("App/Model/Cart.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Cart($config["Database"], "root", "Ayman_Database");

$items = $db -> GetAllOwnedProducts($_SESSION["User"]["UserID"]);

if (count($items) < 1) {
    require("App/View/Errors/Unauthorized.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("Utilities/Middleware/LoggedIn.php");
    if (!empty($_POST["orderlocation"])) {
        if (count($items) < 1) {
            header("Location: /");
        }

        $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_SPECIAL_CHARS);
        $address1 = filter_input(INPUT_POST, "address1", FILTER_SANITIZE_SPECIAL_CHARS);
        $address2 = filter_input(INPUT_POST, "address2", FILTER_SANITIZE_SPECIAL_CHARS);
        $phoneNumber = filter_input(INPUT_POST, "phoneNumber", FILTER_SANITIZE_NUMBER_INT);

        $errors = [];

        if (empty($country) || empty($address1) || empty($address2) || empty($phoneNumber)) {
            array_push($errors, "All Fields Are Required");
        }

        if (empty($errors)) {
            $total = 0;
            foreach ($items as $item) {
                $total += $item["Product_Price"];
            }

            require("vendor/autoload.php");

            $secretKey = $config["API"]["Stripe_Key"];

            \Stripe\Stripe::setApiKey($secretKey);

            foreach ($items as $item) {
                $lineItems[] = [
                    "quantity" => $item["Quantity"],
                    "price_data" => [
                        "currency" => "usd",
                        "unit_amount" => $item["Price"] * 100,
                        "product_data" => [
                            "name" => $item["Name"]
                        ]
                    ]
                ];
            }
            
            $checkout_sess = \Stripe\Checkout\Session::create([
                "mode" => "payment",
                "success_url" => "http://localhost:3000/success?session_id={CHECKOUT_SESSION_ID}&country=" . urlencode($country) . "&address1=" . urlencode($address1) . "&address2=" . urlencode($address2) . "&phonenumber=" . urlencode($phoneNumber),
                "cancel_url" => "http://localhost:3000/",
                "line_items" => $lineItems
            ]);

            $_SESSION["StripeSessionID"] = $checkout_sess -> id;
            $_SESSION["Owner_ID"] = $_SESSION["User"]["UserID"];
            $_SESSION["Location"] = [
                "Country" => $country,
                "Address1" => $address1,
                "Address2" => $address2,
                "Phone_Number" => $phoneNumber
            ];

            header("Location: " . $checkout_sess -> url);

            exit();
        }
    }
}