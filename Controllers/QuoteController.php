<?php

namespace Controllers;

use Database\Database;

class QuoteController extends Database {


    public function index($params) {
        echo $params['id'];
    }

}