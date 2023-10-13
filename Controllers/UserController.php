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

    public function hasAccess($quote_id) {

        $authController = new AuthController();
        $token = $authController->getToken();

        $user_id = $this->getIdByToken($token);

        $sql = "SELECT 1 FROM quotes WHERE id = ? AND user_id = ?";

        $params = [
            $quote_id,
            $user_id
        ];

        $stmt = $this->executeStatement($sql, $params);

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if(is_null($row)) {
            return false;
        }else{
            return true;
        }

    }

}