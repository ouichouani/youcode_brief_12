<?php

namespace App\Core;

class Controller {
    
    protected function view(string $view, array $data = []){
        extract($data);
        $router = new Router();
        echo $router->renderView($view);
    }

    protected function redirect(string $url){
        header('Location: ' . $url);
        exit;
    }
}