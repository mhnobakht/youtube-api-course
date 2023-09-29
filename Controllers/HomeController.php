<?php

namespace Controllers;

class HomeController {


    public function home() {
        $response = [
            'status' => 'OK',
            'message' => 'welcome home'
        ];

        echo json_encode($response);
    }

}