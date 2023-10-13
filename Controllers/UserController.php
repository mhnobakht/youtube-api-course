<?php

namespace Controllers;

use Database\Database;

class UserController extends Database {

    public function getIdByToken($token) {

        $sql = "SELECT id FROM users WHERE token = ?";
        $params = [
            $token
        ];

        $stmt = $this->executeStatement($sql, $params);

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        return $row['id'];

    }

}