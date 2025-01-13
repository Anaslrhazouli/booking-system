<?php
class TicketController extends Controller {
    private $ticketModel;
    private $eventModel;
    private $mailer;
    
    public function __construct() {
        
        $this->ticketModel = new Ticket();
        $this->eventModel = new Event();
        try {
            $this->mailer = new Mailer();
        } catch (Exception $e) {
            error_log('Failed to initialize mailer: ' . $e->getMessage());
            $this->mailer = null;
        }
    }
    
    public function book() {
        $this->loadHeader();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/booking-system/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['event_id']) || !isset($_POST['ticket_type_id'])) {
                $this->redirect('/booking-system/events');
                return;
            }
            
            $ticketData = [
                'user_id' => $_SESSION['user_id'],
                'event_id' => $_POST['event_id'],
                'ticket_type_id' => $_POST['ticket_type_id']
            ];
            
            // Generate a simple QR code string
            $ticketData['qr_code'] = QRGenerator::generate([
    'user_id' => $_SESSION['user_id'],
    'event_id' => $_POST['event_id'],
    'timestamp' => time()
]);

            
            $ticket = $this->ticketModel->bookTicket($ticketData);
            
            if ($ticket) {
                // Try to send email, but don't fail if it doesn't work
                if ($this->mailer) {
                    try {
                        $this->mailer->sendTicketEmail(
                            $ticket['user_email'],
                            $ticket,
                            $ticket['qr_code'] // Use the stored QR code
                        );
                    } catch (Exception $e) {
                        error_log('Failed to send ticket email: ' . $e->getMessage());
                    }
                }
                
                $_SESSION['success_message'] = 'Ticket booked successfully!';
                $this->redirect('/booking-system/tickets/my');
                return;
            } else {
                $_SESSION['error_message'] = 'Failed to book ticket. Please try again.';
                $this->redirect('/booking-system/event/' . $_POST['event_id']);
                return;
            }
        }
        
        $this->redirect('/booking-system/events');
    }
    
    public function myTickets() {
        $this->loadHeader();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/booking-system/login');
            return;
        }
        
        $tickets = $this->ticketModel->getUserTickets($_SESSION['user_id']);
        $this->view('tickets/my-tickets', ['tickets' => $tickets]);
    }
}