<?php
require 'C:\xampp\htdocs\booking-system\app\config\lib\qrlib.php';
class QRGenerator {
    public static function generate($eventData, $savePath = './public/qrcodes/') {
        // Check if all keys exist in the $eventData array, otherwise use default values
        $eventName = isset($eventData['event_name']) ? $eventData['event_name'] : 'Unknown Event';
        $eventDate = isset($eventData['event_date']) ? $eventData['event_date'] : 'Unknown Date';
        $venue = isset($eventData['venue']) ? $eventData['venue'] : 'Unknown Venue';
        $ticketType = isset($eventData['ticket_type']) ? $eventData['ticket_type'] : 'General';
        $userName = isset($eventData['user_name']) ? $eventData['user_name'] : 'Unknown User';
        $userEmail = isset($eventData['user_email']) ? $eventData['user_email'] : 'Unknown Email';
        $bookingDate = isset($eventData['booking_date']) ? $eventData['booking_date'] : 'Unknown Booking Date';
        $timestamp = isset($eventData['timestamp']) ? $eventData['timestamp'] : time();

        // Prepare the QR code data as a readable text string
        $qrData = sprintf(
            "Event: %s\nDate: %s\nVenue: %s\nTicket Type: %s\nUser: %s\nEmail: %s\nBooking Date: %s\nTimestamp: %d",
            $eventName,
            $eventDate,
            $venue,
            $ticketType,
            $userName,  // User's name
            $userEmail, // User's email
            $bookingDate,
            $timestamp
        );

        // Ensure the directory exists
        if (!file_exists($savePath)) {
            mkdir($savePath, 0755, true);
        }

        // Generate a unique filename for the QR code image
        $filename = $savePath . 'QR_' . md5($qrData) . '.png';

        // Generate QR code image if it doesn't exist
        if (!file_exists($filename)) {
            \QRcode::png($qrData, $filename, QR_ECLEVEL_L, 4);
        }

        return $filename;  // Return the path to the QR code image
    }
}
