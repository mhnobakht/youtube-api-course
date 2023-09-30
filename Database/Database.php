<?php

namespace Database;

use Traits\SanitizerTrait;

class Database {

    use SanitizerTrait;

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'ooplogin_dbs';
    private $port     = 3307;
    private $connection;

    public function __construct() {

        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database, $this->port);

        if ($this->connection->connect_error) {

            die('Connection Failed: '.$this->connection->connect_error);

        }

    }

    public function __destruct() {

        $this->connection->close();

    }


    protected function executeStatement($sql, $params = []) {

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            die("Error in preparing Statement: ".$this->connection->error);
        }

        if(!empty($params)) {

            $types = str_repeat('s', count($params));

            $stmt->bind_param($types, ...$params);

        }

        $stmt->execute();
        return $stmt;

    }

}