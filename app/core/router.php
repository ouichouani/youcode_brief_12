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
        $this->routes['get'][$this->clean($path)] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$this->clean($path)] = $callback;
    }

    public function resolve(): void
    {
        $method = strtolower($this->request->getMethod());
        $path = $this->clean($this->request->getPath());

        $callback = $this->routes[$method][$path] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo '404 - Route not found';
            return;
        }

        if (is_string($callback)) {
            echo $this->renderView($callback);
            return;
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }

        call_user_func($callback);
    }

    private function clean(string $path): string
    {
        $path = parse_url($path, PHP_URL_PATH);

        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($base !== '/') {
            $path = substr($path, strlen($base));
        }

        $path = '/' . trim($path, '/');

        return $path === '' ? '/' : $path;
    }


    public function renderView($view)
    {
        $content = $this->renderOnlyView($view);
        $layout = $this->renderLayout();
        return str_replace('{{content}}', $content, $layout);
    }

    public function renderLayout()
    {
        ob_start();
        require dirname(__dir__) . '/views/layout/layout.php';
        return ob_get_clean();
    }

    public function renderOnlyView($view)
    {
        ob_start();
        require dirname(__dir__) . "/views/$view.php";
        return ob_get_clean();
    }
}
