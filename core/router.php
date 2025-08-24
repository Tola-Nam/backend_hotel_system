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
        $method = $_SERVER["REQUEST_METHOD"];
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($method === $route["method"] && preg_match("#^" . $route["path"] . "$#", $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($route["callback"], $matches);
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Route not found"]);
    }
}
