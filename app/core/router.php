<?php

namespace App\core;

use App\core\controller;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function get($url, $controllerAction)
    {
        $this->addRoute('GET', $url, $controllerAction);
    }

    public function post($url, $controllerAction)
    {
        $this->addRoute('POST', $url, $controllerAction);
    }

    private function addRoute($method, $url, $controllerAction)
    {
        $this->routes[$method][$url] = $controllerAction;
    }

    public function dispatch()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($baseDir !== '/' && strpos($url, $baseDir) === 0) {
            $url = substr($url, strlen($baseDir));
        }
        
        $url = rtrim($url, '/') ?: '/';

        if (isset($this->routes[$method][$url])) {
            $controllerAction = $this->routes[$method][$url];
            $this->callControllerAction($controllerAction);
        } else {
            $this->handleNotFound();
        }
    }

    private function callControllerAction($controllerAction)
    {
        list($controllerName, $action) = explode('@', $controllerAction);
        
        $controllerClass = "App\\controllers\\" . $controllerName;
        
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                $this->handleNotFound();
            }
        } else {
            $this->handleNotFound();
        }
    }

    private function handleNotFound()
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}