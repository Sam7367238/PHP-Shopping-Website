<?php

require("App/Model/Users.php");

$config = require("Utilities/Helpers/Configuration.php");
$db = new Users($config["Database"], "root", "Ayman_Database");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["Register"])) {
        $result;
        $errors = [];

        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username) || empty($password)) {
            array_push($errors, "All Fields Are Required");
        }

        if (strlen($username) < 3) {
            array_push($errors, "Username Must Be At Least 3 Characters");
        }

        if (strlen($username) > 20) {
            array_push($errors, "Username Cannot Be Longer Than 20 Characters");
        }

        if (strlen($password) < 8) {
            array_push($errors, "Password Must Be At Least 8 Characters");
        }

        if (strlen($password) > 255) {
            array_push($errors, "Password Cannot Be Longer Than 255 Characters");
        }

        $rows = $db -> GetAllUsers("ByName", $username);

        if (count($rows) > 0) {
            array_push($errors, "A User With The Same Username Already Exists");
        }

        if (empty($errors)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        
            $db -> Register($username, $password);
            $userRow = $db -> GetAllUsers("SingleByName", $username);

            $_SESSION["User"] = [
                "Username" => $username,
                "UserID" => $userRow["ID"]
            ];

            $result = "User Registered Successfully";
        }
    } elseif (!empty($_POST["Login"])) {
        $errors = [];

        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username) || empty($password)) {
            array_push($errors, "All Fields Are Required");
        }

        $row = $db -> GetAllUsers("SingleByName", $username);
        $rowPassword = "";

        if (empty($row)) {
            array_push($errors, "Invalid Username");
        } else {
            $rowPassword = $row["Password"];
        }

        if (!password_verify($password, $rowPassword)) {
            array_push($errors, "Invalid Password");
        }

        if (empty($errors)) {
            $userRow = $db -> GetAllUsers("SingleByName", $username);
            
            $_SESSION["User"] = [
                "Username" => $username,
                "UserID" => $userRow["ID"]
            ];

            header("Location: /");
        }
    }
}