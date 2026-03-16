<?php
/**
 * Base Controller Class
 */
class Controller {
    
    /**
     * Load a model
     */
    protected function model($model) {
        $modelFile = APP_PATH . "/models/{$model}.php";
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        die("Model {$model} không tồn tại.");
    }

    /**
     * Render a view with data
     */
    protected function view($view, $data = []) {
        // Extract data to variables for use in views
        extract($data);
        
        $viewFile = APP_PATH . "/views/{$view}.php";
        if (file_exists($viewFile)) {
            // Start output buffering
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
            
            // Load main layout
            require_once APP_PATH . '/views/layouts/main.php';
        } else {
            die("View {$view} không tồn tại.");
        }
    }

    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header("Location: " . BASE_URL . "/$url");
        exit;
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Require login
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $_SESSION['flash_error'] = 'Vui lòng đăng nhập để tiếp tục.';
            $this->redirect('login');
        }
    }

    /**
     * Set flash message
     */
    protected function setFlash($type, $message) {
        $_SESSION["flash_{$type}"] = $message;
    }
}
