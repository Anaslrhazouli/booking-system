<?php

require_once './app/utils/Mailer.php';  // Adjust this path accordingly

// Instantiate the Mailer class
$mailer = new Mailer();
// Check the logs for the result
echo 'Test email attempt made. Check your logs for success or error.';
