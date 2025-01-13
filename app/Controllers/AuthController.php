<?php

class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function register() {
        $this->loadHeader();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => 'user'
            ];
            
            if ($this->userModel->create($data)) {
                $this->redirect('/booking-system/login');
            }
        }
        $this->view('auth/register');
    }
    
    public function login() {
        $this->loadHeader();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Authenticate user based on email and password
        $user = $this->userModel->authenticate($_POST['email'], $_POST['password']);

        if ($user) {
            // Store the necessary session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name']; // Ensure this is available
            $_SESSION['user_email'] = $user['email']; // Store user email
            $_SESSION['role'] = $user['role'];

            // Redirect after successful login
            $this->redirect('/booking-system');
        } else {
            // Handle authentication failure (Optional)
            echo "Invalid email or password.";
        }
    }

    $this->view('auth/login');
}


  // app/controllers/AuthController.php
  public function logout() {
        // Destroy the session
        session_unset(); // Remove all session variables
        session_destroy(); // Destroy the session

        // Redirect to the home page after logging out
        $this->redirect('/booking-system');
    }

}
