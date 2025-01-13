<?php

session_start();

// Define the ROOT path of your application
define('ROOT_PATH', __DIR__); // __DIR__ is the directory of the current file (index.php)

// Autoload (if applicable)
require_once ROOT_PATH . '/vendor/autoload.php';

// Load core classes (using ROOT_PATH)
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/core/Model.php';

// Load controllers (using ROOT_PATH)
require_once ROOT_PATH . '/app/controllers/AuthController.php';
require_once ROOT_PATH . '/app/controllers/EventController.php';
require_once ROOT_PATH . '/app/controllers/TicketController.php';
require_once ROOT_PATH . '/app/controllers/TestController.php';  // Add this line
require_once ROOT_PATH . '/app/controllers/AdminController.php';

// Load models (using ROOT_PATH)
require_once ROOT_PATH . '/app/models/User.php';
require_once ROOT_PATH . '/app/models/Event.php';
require_once ROOT_PATH . '/app/models/Ticket.php';
require_once ROOT_PATH . '/app/models/TicketType.php';

// Load utilities (using ROOT_PATH)
require_once ROOT_PATH . '/app/utils/QRGenerator.php';
require_once ROOT_PATH . '/app/utils/Mailer.php';

// Get the URI path
$basePath = '/booking-system/'; // Base path of your application
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base path and normalize
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
$path = trim($path, '/');

// Define routes and corresponding controllers/actions
$routes = [
    '' => ['controller' => 'EventController', 'action' => 'list'], // Home page
    'login' => ['controller' => 'AuthController', 'action' => 'login'], // Login
    'register' => ['controller' => 'AuthController', 'action' => 'register'], // Registration
    'events' => ['controller' => 'EventController', 'action' => 'list'], // Events list
    'tickets/my' => ['controller' => 'TicketController', 'action' => 'myTickets'], // My tickets
    'tickets/book' => ['controller' => 'TicketController', 'action' => 'book'], // Add this line#
    'logout' => ['controller' => 'AuthController', 'action' => 'logout'], // Logout route
    'email/test' => ['controller' => 'TestController', 'action' => 'sendTestEmail'], // Add this route
    'admin' => ['controller' => 'AdminController', 'action' => 'dashboard'],
    'admin/users' => ['controller' => 'AdminController', 'action' => 'users'],
    'admin/events' => ['controller' => 'AdminController', 'action' => 'events'],
    'events/create' => ['controller' => 'EventController', 'action' => 'create'], // Events Create
    'events/store' => ['controller' => 'EventController', 'action' => 'store'], // Events Create
    
];

// Function to handle the route
function handleRoute($controllerName, $action) {
    if (!class_exists($controllerName)) {
        throw new Exception("Controller '$controllerName' not found");
    }

    $controller = new $controllerName();
    
    // Make sure to set the root path
    $controller->setRootPath(ROOT_PATH);

    if (!method_exists($controller, $action)) {
        throw new Exception("Action '$action' not found in controller '$controllerName'");
    }

    $controller->$action();
}
try {
    // Check if the route exists
    if (array_key_exists($path, $routes)) {
        $route = $routes[$path];
        handleRoute($route['controller'], $route['action']);
    } elseif (preg_match('/^event\/(\d+)$/', $path, $matches)) {
        // Dynamic route to view an event (e.g., /event/123)
        $controller = new EventController();
        $controller->setRootPath(ROOT_PATH);  // Added this line
        $controller->viewEvent($matches[1]);
    } else {
        // Return a 404 error if no route matches
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
} catch (Exception $e) {
    // Error handling
    header("HTTP/1.0 500 Internal Server Error");
    echo "Server Error: " . $e->getMessage();
}
