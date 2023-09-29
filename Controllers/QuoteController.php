<?php

namespace Controllers;

class QuoteController {


    public function index($params) {
        echo $params['id'];
    }

}