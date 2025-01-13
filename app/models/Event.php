<?php
class Event extends Model {
    protected $table = 'events';
    
    public function getActiveEvents() {
     //   return $this->findAll(['status' => 'active']);
        return $this->findAll();
    }
    
    public function getTicketTypes($eventId) {
        $sql = "SELECT * FROM ticket_types WHERE event_id = ?";
        return $this->query($sql, [$eventId]);
    }

    public function getTicketType($ticketTypeId) {
        $sql = "SELECT * FROM ticket_types WHERE id = ?";
        $result = $this->query($sql, [$ticketTypeId]);
        return $result ? $result[0] : false;
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }
}