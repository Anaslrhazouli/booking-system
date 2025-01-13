<?php

// Include your mailer class (make sure to include the correct namespace or path)
require_once ROOT_PATH . '/app/utils/Mailer.php';

class TestController extends Controller {
    public function sendTestEmail() {
        // Instantiate the Mailer class
        $mailer = new Mailer();
        
    
    }
}
