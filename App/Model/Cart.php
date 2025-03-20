<?php

class Cart extends Database {
    public function __construct($config, $username = "root", $password = "") {
        parent::__construct($config, $username, $password);
    }

    public function GetAllOwnedProducts($owner) {
        $rows = $this->query("
            SELECT Carts.*, Products.Name, Products.Image, Products.Price, Products.Seller_ID  
            FROM Carts 
            JOIN Products ON Carts.Product_ID = Products.ID
            WHERE Carts.Owner_ID = ?;
        ", [$owner])->fetchAll();
        return $rows;
    }
    public function AddToCart($ownerID, $productID) {
        $rows = $this -> query("SELECT * FROM Carts WHERE Owner_ID = ? AND Product_ID = ?;", [$ownerID, $productID]) -> fetchAll();
    
        if (count($rows) < 1) {
            $productPrice = $this -> query("SELECT Price FROM Products WHERE ID = ?;", [$productID])->fetch()["Price"];
    
            $this -> query("INSERT INTO Carts (Owner_ID, Product_ID, Quantity, Product_Price) VALUES (?, ?, ?, ?);", [$ownerID, $productID, 1, $productPrice]);
        } else {
            $quantity = $rows[0]["Quantity"] + 1;
    
            $unitPrice = $rows[0]["Product_Price"] / $rows[0]["Quantity"];
            $totalPrice = $unitPrice * $quantity; 
    
            $this -> query("UPDATE Carts SET Quantity = ?, Product_Price = ? WHERE Product_ID = ? AND Owner_ID = ?;", [$quantity, $totalPrice, $productID, $ownerID]);
        }
    }
    

    public function RemoveFromCart($ownerID, $productID) {
        $rows = $this -> query("SELECT * FROM Carts WHERE Owner_ID = ? AND Product_ID = ?;", [$ownerID, $productID]) -> fetch();
    
        if (!$rows) {
            return;
        }
    
        if ($rows["Quantity"] > 1) {
            $unitPrice = $rows["Product_Price"] / $rows["Quantity"];
            $newQuantity = $rows["Quantity"] - 1;
    
            $newTotalPrice = $unitPrice * $newQuantity;
    
            $this->query("UPDATE Carts SET Quantity = ?, Product_Price = ? WHERE Product_ID = ? AND Owner_ID = ?;", [$newQuantity, $newTotalPrice, $productID, $ownerID]);
        } else {
            $this -> query("DELETE FROM Carts WHERE Product_ID = ? AND Owner_ID = ?;", [$productID, $ownerID]);
        }
    }

    public function EmptyCart($ownerID) {
        $this -> query("DELETE FROM Carts WHERE Owner_ID = ?", [$ownerID]);
    }
}