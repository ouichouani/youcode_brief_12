<?php

namespace App\Core;

class Controller
{

    protected function view(string $view, ?array $data = null)
    {
        if (!$data)
            $data = [];

        $router = new Router();
        echo $router->renderView($view, $data);
    }

    protected function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }
}