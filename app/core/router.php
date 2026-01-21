<?php

namespace App\Core;

use App\Core\Request;

class Router
{

    private $routes = [
        'get' => [],
        'post' => []
    ];

    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {


        $path = strtolower($this->request->getPath());
        $method = strtolower($this->request->getMethod());

        $callback = $this->routes[$method][$path];

        if (is_string($callback)) {
            echo $this->renderView($callback);
            return;
        }


        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        call_user_func($callback);
    }

    public function renderView($view)
    {
        $target_view = $this->renderOnlyView($view);
        $layout = $this->renderLayout();

        return str_replace('{{content}}', $target_view, $layout);
    }

    public function renderLayout()
    {
        ob_start();
        require_once dirname(__dir__) . "/views/layout/layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view)
    {
        ob_start();
        require_once dirname(__dir__) . "/views/$view.php";
        return ob_get_clean();
    }
}
