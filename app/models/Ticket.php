<?php
class Ticket extends Model {
    protected $table = 'tickets';
    public function bookTicket($ticketData) {
        // Start transaction
        $this->db->beginTransaction();
        
        try {
            // First check if tickets are available
            $quantitySql = "SELECT quantity FROM ticket_types 
                           WHERE id = ? AND event_id = ? AND quantity > 0 
                           FOR UPDATE";
            $quantity = $this->query($quantitySql, [
                $ticketData['ticket_type_id'], 
                $ticketData['event_id']
            ]);
            
            if (!$quantity || $quantity[0]['quantity'] <= 0) {
                $this->db->rollBack();
                return false;
            }
            
            // Get event and ticket type details
            $sql = "SELECT 
                e.name as event_name, 
                e.date as event_date,
                e.venue,
                tt.name as ticket_type
                FROM events e
                JOIN ticket_types tt ON tt.event_id = e.id
                WHERE e.id = ? AND tt.id = ?";
            
            $details = $this->query($sql, [$ticketData['event_id'], $ticketData['ticket_type_id']]);
            
            if (!$details) {
                $this->db->rollBack();
                return false;
            }

            // Fetch user details
            $userSql = "SELECT name, email FROM users WHERE id = ?";
            $userDetails = $this->query($userSql, [$ticketData['user_id']]);

            if (!$userDetails) {
                $this->db->rollBack();
                return false;
            }

            // Decrease ticket quantity using the new execute method
            $updateSuccess = $this->execute(
                "UPDATE ticket_types SET quantity = quantity - 1 
                 WHERE id = ? AND event_id = ? AND quantity > 0",
                [$ticketData['ticket_type_id'], $ticketData['event_id']]
            );

            if (!$updateSuccess) {
                $this->db->rollBack();
                return false;
            }

            // Prepare data for QR code
            $qrData = [
                'event_name' => $details[0]['event_name'],
                'event_date' => $details[0]['event_date'],
                'venue' => $details[0]['venue'],
                'ticket_type' => $details[0]['ticket_type'],
                'user_name' => $userDetails[0]['name'],
                'user_email' => $userDetails[0]['email'],
                'booking_date' => date('Y-m-d H:i:s'),
                'timestamp' => time()
            ];

            // Generate and store the QR code
            $ticketData['qr_code_path'] = QRGenerator::generate($qrData);
            $ticketData['booking_date'] = date('Y-m-d H:i:s');

            if ($this->insert($ticketData)) {
                $ticketId = $this->db->lastInsertId();
                
                // Update QR code with ticket ID
                $updatedQrData = $qrData;
                $updatedQrData['ticket_id'] = $ticketId;
                $newQrPath = QRGenerator::generate($updatedQrData);
                
                $updateSuccess = $this->update(
                    ['qr_code_path' => $newQrPath], 
                    ['id' => $ticketId]
                );
                
                if (!$updateSuccess) {
                    $this->db->rollBack();
                    return false;
                }
                
                $this->db->commit();
                return $this->getTicketDetails($ticketId);
            }

            $this->db->rollBack();
            return false;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Ticket booking failed: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getUserTickets($userId) {
        $sql = "SELECT 
                   t.*, 
                   e.name as event_name, 
                   e.date as event_date,
                   e.venue,
                   tt.name as ticket_type,
                   u.email as user_email
                FROM tickets t
                JOIN events e ON t.event_id = e.id
                JOIN ticket_types tt ON t.ticket_type_id = tt.id
                JOIN users u ON t.user_id = u.id
                WHERE t.user_id = ?
                ORDER BY t.booking_date DESC";

        return $this->query($sql, [$userId]) ?: [];
    }
    
    public function getTicketDetails($ticketId) {
        $sql = "SELECT 
                t.*, 
                e.name as event_name, 
                e.date as event_date,
                e.venue,
                tt.name as ticket_type,
                u.email as user_email
            FROM tickets t
            JOIN events e ON t.event_id = e.id
            JOIN ticket_types tt ON t.ticket_type_id = tt.id
            JOIN users u ON t.user_id = u.id
            WHERE t.id = ?";
            
        $result = $this->query($sql, [$ticketId]);
        return $result ? $result[0] : false;
    }
}