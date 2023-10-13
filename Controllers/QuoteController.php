<?php

namespace Controllers;

use Database\Database;
use Traits\SanitizerTrait;

class QuoteController extends Database {

    use SanitizerTrait;
    protected $table = 'quotes';

    public function index() {

        $sql = "SELECT quotes.*, users.name AS username FROM $this->table INNER JOIN users ON users.id = quotes.user_id";
        $stmt = $this->executeStatement($sql);

        $rows = $stmt->get_result();

        if($rows->num_rows <= 0) {
            $response = [
                'status' => 'error',
                'message' => 'no record exists in dbs'
            ];
        }else{
            $response = [];

            while($row = $rows->fetch_assoc()) {
                $data[] = $row;
            }
        }

        

        http_response_code(200);
        echo json_encode($data);
        
    }

    public function getQuote($params) {
        $id = $params['id'];

        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $sql_params = [$id];

        $stmt = $this->executeStatement($sql, $sql_params);

        $row = $stmt->get_result();

        $row = $row->fetch_assoc();

        if(is_null($row)) {
            $response = [
                'status' => 'error',
                'message' => 'record not found.'
            ];
        }else{
            $response = $row;
        }

        http_response_code(200);
        echo json_encode($response);
    }

    public function store() {
        // get token
        $authController = new AuthController();
        $token = $authController->getToken();

        // get user id
        $userController = new UserController();
        $user_id = $userController->getIdByToken($token);


        $data = $this->sanitizeInput($_POST);

        if(!array_key_exists('quote', $data) || !array_key_exists('author', $data)) {
            $response = [
                'status' => 'error',
                'message' => 'invalid inputs'
            ];
        }else{
            $sql = "INSERT INTO $this->table (user_id, quote, author) VALUES (?, ?, ?)";

            $params = [
                $user_id,
                $data['quote'],
                $data['author']
            ];

            $stmt = $this->executeStatement($sql, $params);

            if($stmt->affected_rows == 1) {
                $response = [
                    'status' => 'ok',
                    'quote_id' => $stmt->insert_id,
                    'message' => 'Quote added successfully'
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'message' => 'can not insert new row'
                ];
            }
        }


        echo json_encode($response);
    }


    public function update($id) {
        $id = $this->sanitizeInput($id['id']);
        $put_data = file_get_contents("php://input");
        parse_str($put_data, $data);
        $data = $this->sanitizeInput($data);
        
        $sql = "UPDATE $this->table SET ";

        $updates = [];

        foreach($data as $key => $value) {
            $updates[] = "$key = '$value'";
        }

        $sql .= implode(', ', $updates);

        $sql .= ", updated_at = NOW() WHERE id = ?";

        $params = [
            $id
        ];

        $stmt = $this->executeStatement($sql, $params);

        if($stmt->affected_rows == 1) {
            $response = [
                'status' => 'ok',
                'message' => 'record updated successfully'
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'can not update the row'
            ];
        }

        echo json_encode($response);
    }


    public function delete($id) {
        $id = $this->sanitizeInput($id['id']);

        // check permission
        $user = new UserController();
        $access = $user->hasAccess($id);

        if(!$access) {
            $response = [
                "error" => '403 forbidden',
                "message" => 'you dont have access to this record.'
            ];

            http_response_code(403);
            echo json_encode($response);die;
        }

        $sql = "DELETE FROM $this->table WHERE id = ?";
        $params = [
            $id
        ];

        $stmt = $this->executeStatement($sql, $params);

        if($stmt->affected_rows == 1) {
            $response = [
                'status' => 'OK',
                'message' => 'record deleted successfully'
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'can not delete the record'
            ];
        }

        echo json_encode($response);
    }

    public function quoteByAuthor($author) {
        $author = $this->sanitizeInput($author['author']);
        $author = str_replace('%20', ' ', $author);
        
        $sql = "SELECT * FROM $this->table WHERE author = ?";
        $params = [
            $author
        ];

        $stmt = $this->executeStatement($sql, $params);

        $rows = $stmt->get_result();

        if($rows->num_rows <= 0) {
            $response = [
                'status' => 'error',
                'message' => 'no record exists in dbs'
            ];
        }else{
            $response = [];

            while($row = $rows->fetch_assoc()) {
                $response[] = $row;
            }
        }

        echo json_encode($response);
    }


    public function getQuoteByUserId($id) {
        $id = $this->sanitizeInput($id['id']);

        $sql = "SELECT quotes.*, users.name AS username FROM $this->table INNER JOIN users ON users.id = quotes.user_id WHERE users.id = ?";

        $params = [$id];

        $stmt = $this->executeStatement($sql, $params);

        $rows = $stmt->get_result();

        if($rows->num_rows <= 0) {
            $response = [
                'status' => 'error',
                'message' => 'no record exists in dbs'
            ];
        }else{
            $response = [];

            while($row = $rows->fetch_assoc()) {
                $response[] = $row;
            }
        }

        echo json_encode($response);
    }

}