<?php
/**
 * Router Class - Simple URL routing
 */
class Router {
    private $routes = [];

    /**
     * Add a route
     */
    public function add($pattern, $controller, $action) {
        $this->routes[] = [
            'pattern'    => $pattern,
            'controller' => $controller,
            'action'     => $action,
        ];
    }

    /**
     * Dispatch URL to appropriate controller/action
     */
    public function dispatch($url) {
        $url = trim($url, '/');

        foreach ($this->routes as $route) {
            $pattern = $route['pattern'];

            // Convert {param} to regex
            $regex = preg_replace('/\{(\w+)\}/', '(\w+)', $pattern);
            $regex = "#^{$regex}$#";

            if (preg_match($regex, $url, $matches)) {
                array_shift($matches); // Remove full match

                $controllerName = $route['controller'];
                $actionName = $route['action'];

                // Load controller
                $controllerFile = APP_PATH . "/controllers/{$controllerName}.php";
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $controllerName();

                    if (method_exists($controller, $actionName)) {
                        call_user_func_array([$controller, $actionName], $matches);
                        return;
                    } else {
                        $this->error404("Action {$actionName} không tồn tại.");
                        return;
                    }
                } else {
                    $this->error404("Controller {$controllerName} không tồn tại.");
                    return;
                }
            }
        }

        $this->error404();
    }

    /**
     * Show 404 page
     */
    private function error404($message = '') {
        http_response_code(404);
        $pageTitle = 'Không tìm thấy trang';
        require_once APP_PATH . '/views/errors/404.php';
    }
}
