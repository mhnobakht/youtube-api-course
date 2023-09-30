<?php

namespace Controllers;

use Database\Database;

class QuoteController extends Database {

    protected $table = 'quotes';

    public function index() {

        $sql = "SELECT * FROM ".$this->table;
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

}