<?php

namespace booking_m;

class Booking_model{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getBookings()
    {
        return $this->db->get("bookings");
    }

    public function getBookingbyid($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('bookings');
    }
    
    public function insertBookings($data)
    {
        $booking=$this->db->insert('bookings', $data);
        if ($booking) {
            $response = [
                "status"=>true,
                'message' => 'booking was added'
            ];
            return $response;
        } else {
            $response = [
                "status" => false,
                'message' => 'failed to add booking: ' . $this->db->getLastError()
            ];
            return $response;
        }
    }

    public function updateBookings($data, $id)
    {
        $this->db->where("id", $id);
        if ($this->db->update("bookings", $data)) {
            $response = [
                "status" => true,
                'message' => 'Booking was updated'
            ];
            return $response;
        } else {
            $response = [
                "status" => false,
                'message' => 'update failed : ' . $this->db->getLastError()
            ];
            return $response;
        }
    }

    public function deleteBookings($id)
    {
        $this->db->where("id", $id);
        if ($this->db->delete("bookings")) {
            $response = [
                "status" => true,
                'message' => 'Booking was deleted'
            ];
            return $response;
        } else {
            $response = [
                "status" => false,
                'message' => 'delete failed : ' . $this->db->getLastError()
            ];
            return $response;
        }
    }
}

?>
