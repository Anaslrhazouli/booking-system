<?php

class AdminController extends Controller {
    private $userModel;
    private $eventModel;
    private $ticketModel;

    public function __construct() {
        $this->userModel = new User();
        $this->eventModel = new Event();
        $this->ticketModel = new Ticket();
    }

    // Middleware to check if user is admin
    private function checkAdminAccess() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/booking-system');
            exit;
        }
    }

    public function dashboard() {
        $this->checkAdminAccess();
        $this->loadHeader();

        // Get ticket bookings with user and event details
        $ticketBookings = $this->ticketModel->query("
            SELECT 
                t.id as ticket_id,
                t.booking_date,
                u.name as user_name,
                u.email as user_email,
                e.name as event_name,
                tt.name as ticket_type
            FROM tickets t
            JOIN users u ON t.user_id = u.id
            JOIN events e ON t.event_id = e.id
            JOIN ticket_types tt ON t.ticket_type_id = tt.id
            ORDER BY t.booking_date DESC
            LIMIT 10
        ");

        // Get statistics for the dashboard
        $data = [
            'totalUsers' => count($this->userModel->findAll()),
            'totalEvents' => count($this->eventModel->findAll()),
            'totalTickets' => count($this->ticketModel->findAll()),
            'recentUsers' => $this->userModel->query("SELECT * FROM users ORDER BY id DESC LIMIT 5"),
            'recentEvents' => $this->eventModel->query("SELECT * FROM events ORDER BY id DESC LIMIT 5"),
            'ticketBookings' => $ticketBookings
        ];

        $this->view('admin/dashboard', $data);
    }

    public function users() {
        $this->checkAdminAccess();
        $this->loadHeader();
        
        $data = [
            'users' => $this->userModel->findAll()
        ];
        
        $this->view('admin/users', $data);
    }

    public function events() {
        $this->checkAdminAccess();
        $this->loadHeader();
        
        $data = [
            'events' => $this->eventModel->findAll()
        ];
        
        $this->view('admin/events', $data);
    }
}