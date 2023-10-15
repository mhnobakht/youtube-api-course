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

    public function register() {
        if(!array_key_exists('email', $_POST)) {
            $response = [
                'status' => 'error',
                'message' => 'please send your email address with name email'
            ];

            echo json_encode($response);die;
        }

        $email = $this->sanitizeInput($_POST['email']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = [
                'status' => 'error',
                'message' => 'please send your email address with name email'
            ];

            echo json_encode($response);die;
        }

        $emailArray = explode('@', $email);
        $name = $emailArray[0];
        
        $token = bin2hex(random_bytes(32));
        

        $sql = "INSERT INTO users (name, email, token) VALUES (?, ?, ?)";
        $params = [
            $name,
            $email,
            $token
        ];

        $stmt = $this->executeStatement($sql, $params);

        if($stmt->affected_rows == 1) {
            MailController::send($email, 'token', $token);
            $response = [
                'status' => 'ok',
                'message' => 'please check your inbox'
            ];

            echo json_encode($response);
        }
    }

}