<?php

namespace Controllers;

use Database\Database;
use Traits\SanitizerTrait;

class AuthController extends Database {

    use SanitizerTrait;

    public function validateToken() {
        
        $token = $this->getToken();

        if(is_null($token)) {
            return false;
        }

        $sql = "SELECT id FROM users WHERE token = ?";
        $params = [
            $token
        ];

        $stmt = $this->executeStatement($sql, $params);

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if(is_null($row)) {
            return false;
        }

        return true;

    }

    public function getToken() {

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        if(is_null($authHeader)) {
            return null;
        }

        if(!str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        $token = substr($authHeader, 7);

        if(is_null($token) || $token == '') {
            return null;
        }

        return $this->sanitizeInput($token);

    }

    public function unauthorizedUser() {
        $response = [
            "status" => "Unauthorized user",
            'status_code' => '401'
        ];
        http_response_code(401);

        echo json_encode($response);
    }

}