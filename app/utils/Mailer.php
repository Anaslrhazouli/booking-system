<?php

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Attachment;

class Mailer {
    private $config;
    private $mailerSend;

    public function __construct() {
        // Get the absolute path to config file
        $configPath = dirname(__DIR__) . '/config/email.php';

        if (!file_exists($configPath)) {
            $this->config = [
                'api_key' => 'your-mailersend-api-key',  // Replace with your MailerSend API key
                'from_email' => 'anaslrh2@gmail.com',
                'from_name' => 'Event Booking System'
            ];
        } else {
            $this->config = require $configPath;
        }

        // Initialize MailerSend
        try {
            $this->mailerSend = new MailerSend([
                'api_key' => $this->config['api_key']
            ]);
        } catch (Exception $e) {
            error_log('MailerSend initialization failed: ' . $e->getMessage());
            $this->mailerSend = null;
        }
    }

    public function sendTicketEmail($to_email, $ticket, $qrCodePath) {
        if ($this->mailerSend === null) {
            error_log('MailerSend is not initialized.');
            return false;
        }

        try {
            // Create recipients
            $recipients = [
                new Recipient($to_email, 'Ticket Recipient')
            ];

            // Get the full path to the QR code image
            $qrCodeFullPath = realpath(__DIR__ . '/../../public/qrcodes/' . basename($qrCodePath));

            // Log the full path for debugging
            error_log('QR Code full path: ' . $qrCodeFullPath);

            // Check if the QR code file exists
            if (!file_exists($qrCodeFullPath)) {
                error_log('QR code file not found: ' . $qrCodeFullPath);
                return false; // Stop if the file is missing
            }
// Read and encode QR code as base64
$qrCodeData = file_get_contents($qrCodeFullPath);
$qrCodeBase64 = base64_encode($qrCodeData);
            error_log('Base64 Image Length: ' . strlen($qrCodeBase64));
            error_log('QR Code MIME Type: image/png');
            // Create HTML email template with embedded QR code
            $htmlContent = '
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                        }
                        .ticket-container {
                            background-color: #f9f9f9;
                            border: 1px solid #ddd;
                            border-radius: 8px;
                            padding: 20px;
                            margin-bottom: 20px;
                        }
                        .ticket-header {
                            font-size: 24px;
                            color: #2c3e50;
                            margin-bottom: 20px;
                            text-align: center;
                        }
                        .ticket-details {
                            margin-bottom: 20px;
                        }
                        .ticket-detail {
                            margin-bottom: 10px;
                        }
                        .label {
                            font-weight: bold;
                            color: #7f8c8d;
                        }
                        .qr-container {
                            text-align: center;
                            margin-top: 20px;
                        }
                        .qr-code {
                            max-width: 200px;
                            margin: 0 auto;
                        }
                        .footer {
                            text-align: center;
                            font-size: 14px;
                            color: #666;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class="ticket-container">
                        <div class="ticket-header">
                            Your Event Ticket
                        </div>
                        <div class="ticket-details">
                            <div class="ticket-detail">
                                <span class="label">Event:</span> ' . htmlspecialchars($ticket['event_name']) . '
                            </div>
                            <div class="ticket-detail">
                                <span class="label">Date:</span> ' . htmlspecialchars($ticket['event_date']) . '
                            </div>
                            <div class="ticket-detail">
                                <span class="label">Venue:</span> ' . htmlspecialchars($ticket['venue']) . '
                            </div>
                            <div class="ticket-detail">
                                <span class="label">Ticket Type:</span> ' . htmlspecialchars($ticket['ticket_type']) . '
                            </div>
                        </div>
                        <div class="qr-container">
                        <p><strong>Your Entry QR Code:</strong></p>
                <img src="data:image/png;base64,' . $qrCodeBase64 . '" alt="QR Code" class="qr-code">
                <p>Please show this QR code at the event entrance.</p>
                
                        </div>
                    </div>
                    <div class="footer">
                        <p>Thank you for your purchase!</p>
                        <p>If you have any questions, please contact our support team.</p>
                    </div>
                </body>
                </html>
            ';

            // Create plain text version
            $textContent = "Your Event Ticket\n\n" . 
                "Event: " . $ticket['event_name'] . "\n" . 
                "Date: " . $ticket['event_date'] . "\n" . 
                "Venue: " . $ticket['venue'] . "\n" . 
                "Ticket Type: " . $ticket['ticket_type'] . "\n\n" . 
                "Please show your QR code at the event entrance.\n\n" . 
                "Thank you for your purchase!\n" . 
                "If you have any questions, please contact our support team.";

            // Create email parameters
            $emailParams = (new EmailParams())
                ->setFrom($this->config['from_email'])
                ->setFromName($this->config['from_name'])
                ->setRecipients($recipients)
                ->setSubject('Your Ticket for ' . $ticket['event_name'])
                ->setHtml($htmlContent)
                ->setText($textContent);

            // Send the email using MailerSend
            $this->mailerSend->email->send($emailParams);
            return true;
        } catch (Exception $e) {
            error_log('MailerSend Error: ' . $e->getMessage());
            return false;
        }
    }
}

?>
