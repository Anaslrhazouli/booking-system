    <?php

    class EventController extends Controller {
    private $eventModel;
    private $ticketTypeModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->ticketTypeModel = new TicketType();
    }

    private function checkAdminAccess() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = 'Access denied. Admin privileges required.';
            $this->redirect('/booking-system/events');
            exit;
        }
    }

    public function list() {
        $this->loadHeader();
        $events = $this->eventModel->getActiveEvents();
        $this->view('events/list', ['events' => $events]);
    }

    public function create() {
        $this->checkAdminAccess();
        $this->loadHeader();
        $this->view('events/create');
    }

    public function store() {
        session_start();
$userId = $_SESSION['user_id'] ?? null;
        // Assume $_POST contains the event data
        $eventData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'date' => $_POST['date'],
            'venue' => $_POST['venue'],
            'created_by' => $userId,  // Set the user ID
        ];

        // Insert the event and get the event ID
        $eventModel = new Event();
        $eventModel->insert($eventData);
        $eventId = $eventModel->lastInsertId();

        // Handle ticket types
        if (!empty($_POST['ticket_types'])) {
            $ticketTypeModel = new TicketType();

            foreach ($_POST['ticket_types'] as $ticketType) {
                $ticketTypeData = [
                    'event_id' => $eventId,
                    'name' => $ticketType['name'],
                    'price' => $ticketType['price'],
                    'quantity' => $ticketType['quantity']
                ];

                $ticketTypeModel->insert($ticketTypeData);
            }
        }

        // Redirect or render success message
        header("Location: /booking-system/events");
        exit;
    }

    public function viewEvent($id) {
        $this->loadHeader();
        $event = $this->eventModel->findOne(['id' => $id]);
        
        if (!$event) {
            $_SESSION['error_message'] = 'Event not found';
            $this->redirect('/booking-system/events');
            return;
        }

        $ticketTypes = $this->eventModel->getTicketTypes($id);
        $this->view('events/view', ['event' => $event, 'ticketTypes' => $ticketTypes]);
    }
}