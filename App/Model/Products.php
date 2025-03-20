<?php

class Products extends Database {
    public function __construct($config, $username = "root", $password = "") {
        parent::__construct($config, $username, $password);
    }

    public function GetAllProducts($filter = "All", $productID = 0) {
        
        if ($filter == "All") {
            $rows = $this -> query("SELECT * FROM Products;") -> fetchAll();
            return $rows;
        } elseif ($filter == "SingleByID") {
            $rows = $this -> query("SELECT * FROM Products WHERE ID = ?;", [$productID]) -> fetch();
            return $rows;
        } else {
            $rows = $this -> query("SELECT * FROM Products;") -> fetchAll();
            return $rows;
        }
    }

    public function NewProduct($productName, $productPrice, $productImage, $sellerID) {
        $this -> query("INSERT INTO Products (Name, Price, Image, Seller_ID) VALUES (?, ?, ?, ?)", [$productName, $productPrice, $productImage, $sellerID]);
    }

    public function VoidProduct($id) {
        $this -> query("DELETE FROM Products WHERE ID = ?", [$id]);
    }
}