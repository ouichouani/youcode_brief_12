<?php

namespace App\Core;
use App\Core\Router ;

class Controller
{

    protected function view(string $view, ?array $data = null)
    {
        if (!$data)
            $data = [];

        $router = new Router();
        echo $router->renderView($view, $data);
        // echo $router->renderLayout() ;
    }

    protected function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }
}