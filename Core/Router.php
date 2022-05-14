<?php
    namespace ApiFramework\Core;
    use ApiFramework\Controllers;

    class Router 
    {
        private static array $paths = array();

        private static array $special = array();

        public static function add(string $pathStr, string $controller, string $method, RequestMethod $requestMethod=RequestMethod::All) {
            $path = new Path();
            $path->pathStr = $pathStr;
            $path->controller = $controller;
            $path->method = $method;
            $path->requestMethod = $requestMethod;

            if (class_exists("ApiFramework\\Controllers\\" . $controller . "Controller")) {
                array_push(self::$paths, $path);
                return;
            } else {
                echo "Controller {$controller}Controller not found.<br />";
                die;
            }
        }

        public static function add404(string $controller, string $method) {
            self::$special['404'] = ['controller' => $controller, 'method' => $method];
        }

        public static function callPath() {
            $requestPath = parse_url($_SERVER['REQUEST_URI']);

            foreach (self::$paths as $index => $path) {
                $found = self::compare($requestPath["path"], $path->pathStr);
                if ($found) {
                    break;
                }
            }

            if (!$found) {
                self::show404();
            }
        }

        private static function compare(string $actualPath, string $storedPath): bool {

            $actualTokens = explode("/", trim($actualPath, '\\/'));
            $storedTokens = explode("/", trim($storedPath, '\\/'));

            $params = array();

            if (sizeof($actualTokens) != sizeof($storedTokens)) {
                return false;
            }

            foreach($actualTokens as $index => $actualToken) {
                if (strlen($storedTokens[$index]) == 0 || $storedTokens[$index][0] != "{") {
                    if (strcmp($storedTokens[$index], trim($actualToken, '/\\')) != 0) {
                        return false;
                    }
                } else {
                    $trimmed = trim($storedTokens[$index], '{}');
                    $params[$trimmed] = $actualToken;
                }
            }

            $foundPath = null;
            foreach (self::$paths as $path) {
                if ($path->requestMethod == RequestMethod::All || $path->requestMethod == $_SERVER['REQUEST_METHOD']) {
                    if (strcmp(trim($path->pathStr, '\\/'), trim($storedPath, '\\/')) == 0) {
                        $foundPath = $path;
                    }
                }
            }

            if ($foundPath == null) {
                show404();                
                return true;
            }

            $controllerName = "ApiFramework\\Controllers\\" . $foundPath->controller . "Controller";
            $controller = new $controllerName();

            if (!method_exists($controller, $foundPath->method)) {
                // method not found
                echo "Method {$foundPath->method} not found in controller {$foundPath->controller}.";
                die;
            };

            $method = $foundPath->method;
            $controller->$method($params);

            return true;
        }

        private static function show404() {
            if (isset(self::$special['404'])) {
                $controllerName = "ApiFramework\\Controllers\\" . self::$special['404']['controller'] . "Controller";
                $controller = new $controllerName();
                $method = self::$special['404']['method'];
                $controller->$method([]);
            } else {
                echo "Error 404<br/>Page not found.";             
            }
        }
    }