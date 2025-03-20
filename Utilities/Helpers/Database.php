<?php

class Database {
    private static ?PDO $connection = null;

    public function __construct($config, $username = "root", $password = "") {

        if (self::$connection == null) {
            $dsn = "mysql:" . http_build_query($config, "", ";");

            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
    
            $this -> query("
                CREATE TABLE IF NOT EXISTS Users (
                    ID INT AUTO_INCREMENT PRIMARY KEY,
                    Username VARCHAR(20) UNIQUE,
                    Password TEXT
                );

                CREATE TABLE IF NOT EXISTS Products (
                    ID INT AUTO_INCREMENT PRIMARY KEY,
                    Name VARCHAR(255),
                    Price DECIMAL(10, 2),
                    Seller_ID INT,
                    Image VARCHAR(255) DEFAULT NULL,
                    CONSTRAINT FOREIGN KEY (Seller_ID) REFERENCES Users (ID) ON DELETE CASCADE
                );

                CREATE TABLE IF NOT EXISTS Carts (
                    ID INT AUTO_INCREMENT PRIMARY KEY,
                    Owner_ID INT,
                    Product_ID INT,
                    Quantity INT DEFAULT 1,
                    Product_Price DECIMAL(10, 2) DEFAULT 0,
                    CONSTRAINT FOREIGN KEY (Owner_ID) REFERENCES Users (ID) ON DELETE CASCADE,
                    CONSTRAINT FOREIGN KEY (Product_ID) REFERENCES Products (ID) ON DELETE CASCADE
                );

                CREATE TABLE IF NOT EXISTS Orders (
                    ID INT AUTO_INCREMENT PRIMARY KEY,
                    Seller_ID INT,
                    Buyer_ID INT,
                    Country VARCHAR(40),
                    Address1 VARCHAR(255),
                    Address2 VARCHAR(255),
                    Phone_Number INT,
                    CONSTRAINT FOREIGN KEY (Seller_ID) REFERENCES Products (Seller_ID) ON DELETE CASCADE,
                    CONSTRAINT FOREIGN KEY (Buyer_ID) REFERENCES Users (ID) ON DELETE CASCADE
                );

                CREATE TABLE IF NOT EXISTS Order_Products (
                    ID INT AUTO_INCREMENT PRIMARY KEY,
                    Order_ID INT,
                    Product_Name VARCHAR(255),
                    Quantity INT,
                    CONSTRAINT FOREIGN KEY (Order_ID) REFERENCES Orders (ID) ON DELETE CASCADE
                );
            ");
        }
    }

    public function getLastInsertID() {
        return self::$connection -> lastInsertId();
    }

    public function query($query, $params = []) {
        $statement = self::$connection -> prepare($query);
        $statement -> execute($params);

        return $statement;
    }
}