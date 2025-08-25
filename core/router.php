<?php
class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = compact("method", "path", "callback");
    }

    public function router()
    {
        // Ensure method and URI are always set
        $method = $_SERVER["REQUEST_METHOD"] ?? 'GET';

        // $_SERVER['REQUEST_URI'] may be null in some environments
        $uri = $_SERVER["REQUEST_URI"] ?? '/index';
        $uri = parse_url($uri, PHP_URL_PATH) ?? '/index'; // ensure parse_url returns a string

        foreach ($this->routes as $route) {
            if ($method === $route["method"] && preg_match("#^" . $route["path"] . "$#", (string) $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($route["callback"], $matches);
            }
        }

        // Send 404 if no route matched
        if (!headers_sent()) {
            http_response_code(404);
        }

        echo json_encode(["error" => "Route not found"]);
    }
}
