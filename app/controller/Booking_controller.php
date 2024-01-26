<?php

namespace booking_c;

class Booking_controller
{
    private $booking, $customer, $hotel, $ticket;

    public function __construct($booking, $customer, $hotel,$ticket)
    {
        $this->booking = $booking;
        $this->customer = $customer;
        $this->hotel = $hotel;
        $this->ticket = $ticket;
       
    }
    
    public function selectOneBooking()
    {
        $id = $_GET["id"];
        if ($this->validateId($id)) {
            $booking = $this->booking->getOneBooking($id);
            echo json_encode($booking);

        }
    }
   
    public function showBookings()
    {
        $bookings = $this->booking->getBookings();
        $data=array();
        foreach($bookings as $key => $value )
        {
            $customerName = $this->customer->getCustomerValue($value["customer_id"]);   
            $date_s= $this->ticket->geticketinfo($value["ticket_id"], "date_s");
            $date_e= $this->ticket->geticketinfo($value["ticket_id"], "date_e");
            $hotelName = $this->hotel->getHotelName($value["hotel_id"],"name");
            $data["bookings"][]=[
                "id"=> $value["id"],
                "date_s"=>"$date_s",
                "date_e"=>"$date_e",
                "customer"=>" $customerName",
                "hotel"=>"$hotelName"
            ];
        }

        echo(json_encode($data)) ;
        
    }

    public function insertBooking()
    {
        $ticketId = $_POST['ticket_id'] ?? "";
        $customerId = $_POST['customer_id'] ?? "";
        $hotelId=$_POST["hotel_id"] ?? "";
        $date = date("y/m/d");

        if ($this->validateId($ticketId) && $this->validateId($customerId) && $this->validateId($hotelId)) {
            $data = [
                "ticket_id" => "$ticketId",
                "customer_id" => "$customerId",
                "hotel_id" => "$hotelId",
                "date"=>"$date"
            ];
            $insert = $this->booking->insertBookings($data);
            echo json_encode($insert);
        }
    }

    public function updatebooking()
    {
        $id = $_GET["id"];
        if ($this->validateId($id)) {
            if ($this->booking->getBookingbyid($id)) {
            $ticketId = $_POST['ticket_id'] ?? "";
            $customerId = $_POST['customer_id'] ?? "";
            $hotelId = $_POST["hotel_id"] ?? "";
            $data = array();

            if ($this->validateId($ticketId)) {
                $data['ticket_id'] = $ticketId;
            }

            if ($this->validateId($customerId)) {
                $data['customer_id'] = $customerId;
            }

            if ($this->validateId($hotelId)) {
                $data['hotel_id'] = $hotelId;
            }

            if (!empty($data)) {
                $update = $this->booking->updatebookings($data, $id);
                echo json_encode($update);
                }
        } else {
            $response["status"] = false;
            echo json_encode($response);
        }
        }
    }
    public function deleteBooking()
    {
        $id = $_GET["id"];
        if ($this->validateId($id)) {
            if ($this->booking->getBookingbyid($id)) {
            $delete = $this->booking->deleteBookings($id);
            echo json_encode($delete);
            } else {
                    $response["status"] = false;
                    echo json_encode($response);
                }
        }
    }
    

    function validateId($id)
    {

        $response = array();

        if (is_numeric($id)) {
            return true;
        } else {
            $response["status"] = false;
            $response["msgErr"] = "id should be integer number";
            echo json_encode($response);
        }
    }

}