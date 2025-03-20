<?php

class Users extends Database {
    public function __construct($config, $username = "root", $password = "") {
        parent::__construct($config, $username, $password);
    }

    public function GetAllUsers($filter = "", $username = "", $userid = 0) {
        if ($filter == "ByName") {
            if (empty($username)) {
                return;
            }

            $rows = $this -> query("SELECT * FROM Users WHERE Username = ?;", [$username]) -> fetchAll();
            return $rows;
        } elseif ($filter == "SingleByName") {
            if (empty($username)) {
                return;
            }

            $rows = $this -> query("SELECT * FROM Users WHERE Username = ?;", [$username]) -> fetch();
            return $rows;

        } elseif ($filter == "ByID") {
            if (empty($userid)) {
                return;
            }

            $rows = $this -> query("SELECT * FROM Users WHERE ID = ?;", [$userid]) -> fetch();

            return $rows;
        } else {
            $rows = $this -> query("SELECT * FROM Users;") -> fetchAll();
            return $rows;
        }
    }


    public function Register($username, $password) {
        $this -> query("INSERT INTO Users (Username, Password) VALUES (?, ?)", [$username, $password]);
    }
}