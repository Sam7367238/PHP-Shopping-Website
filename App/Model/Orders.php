<?php

class Orders extends Database {
    public function __construct($config, $username = "root", $password = "") {
        parent::__construct($config, $username, $password);
    }

    public function CreateOrder($sellerID, $buyerID, $country, $address1, $address2, $phone_number) {
        $this -> query("
            INSERT INTO Orders (
                Seller_ID, 
                Buyer_ID, 
                Country, 
                Address1, 
                Address2, 
                Phone_Number
            ) VALUES (?, ?, ?, ?, ?, ?);", 
            [$sellerID, $buyerID, $country, $address1, $address2, $phone_number]
        );

        return $this -> getLastInsertID();
    }

    public function AddOrderProduct($name, $quantity, $orderID) {
        $this -> query("INSERT INTO Order_Products (Order_ID, Product_Name, Quantity) VALUES (?, ?, ?);", [$orderID, $name, $quantity]);
    }

    public function GetOrdersForSeller($sellerID) {
        $rows = $this -> query("SELECT * FROM Orders WHERE Seller_ID = ?", [$sellerID]) -> fetchAll();
        return count($rows) < 1 ? "None" : $rows;
    }

    public function VoidOrder($orderID) {
        $this -> query("DELETE FROM Orders WHERE ID = ?", [$orderID]);
    }

    public function ValidateOrderByID($orderID, $userid) {
        $rows = $this -> query("SELECT * FROM Orders WHERE ID = ? AND Seller_ID = ?", [$orderID, $userid]) -> fetch();

        if (!$rows) {
            return "Not Found";
        } else {
            return "Found";
        }
    }

    public function GetOrderProductsForOrder($orderID) {
        $rows = $this -> query("SELECT * FROM Order_Products WHERE Order_ID = ?", [$orderID]) -> fetchAll();
        return $rows;
    }
}