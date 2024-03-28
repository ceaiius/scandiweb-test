<?php

declare(strict_types=1);

namespace App\Modules;

class Router
{
    private $handlers;
    private $notFoundHandler;
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';

    public function __construct(){
        $this->handlers    = [];
        $this->notFoundHandler = '';
    }

    public function get(string $path, callable $handler): void
    {
        $this->handler(self::METHOD_GET, $path, $handler);
    }
    public function post(string $path, $handler): void
    {
        $this->handler(self::METHOD_POST, $path, $handler);
    }

    private function handler(string $method, string $path, $handler): void
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function notFoundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function execute()
    {
        $requestURI = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestURI['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = null;

        foreach ($this->handlers as $handler) {
            if($handler['path'] === $requestPath && $method === $handler['method']) {
                $callback = $handler['handler'];
            }
        }

        if(!$callback) {
            header("HTTP/1.0 404 Not Found");
            if(!empty($this->notFoundHandler)){
                $callback = $this->notFoundHandler;
            }
        }

        call_user_func_array($callback, [
           array_merge($_GET, $_POST)
        ]);
        header("HTTP/1.1 200 OK");
    }
}