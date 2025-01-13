<?php
class Controller {
    protected $rootPath;

    public function setRootPath($path) {
        $this->rootPath = $path;
    }
    public function loadHeader() {
        include $this->rootPath . '/app/views/header.php';
    }

    protected function view($view, $data = []) {
       
        
        extract($data);
        $viewPath = $this->rootPath . '/app/views/' . $view . '.php';
        
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // List contents of the views directory
            $viewsDir = $this->rootPath . '/app/views/events';
            echo "Contents of views directory (" . $viewsDir . "):<br>";
            if (is_dir($viewsDir)) {
                $files = scandir($viewsDir);
                foreach ($files as $file) {
                    echo "- " . $file . "<br>";
                }
            } else {
                echo "Views directory does not exist!<br>";
            }
            
            die("View not found: " . $viewPath);
        }
    }

    protected function redirect($path) {
        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }
        header("Location: " . $path);
        exit;
    }
}