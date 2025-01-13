<?php

class View {
    public static function render($view, $data = []) {
        extract($data);

        // Get the absolute path to the views directory
        $viewPath = __DIR__ . "/../views/{$view}.php";
        
        

        // Check if the view file exists
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Output an error if the view is not found
            die("View not found: {$viewPath}");
        }
    }
}
