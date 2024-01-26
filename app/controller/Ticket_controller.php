<?php
namespace ticket_c;
class Ticket_controller
{ private $ticket, $company, $city;
    public function __construct($ticket,$company,$city)
    {
        $this->ticket=$ticket;
        $this->company=$company;
        $this->city=$city;
    }
    //..........................................................
    public function showTickets()
    {
        $data = array();
        $data["status"] = true;
        $tickets = $this->ticket->getTickets();
        foreach ($tickets as $key => $value) {
            $company = $this->company->getCompanyValue($value["company_id"]);
            $city = $this->city->getCityValue($value["city_id"]);
            $data["tickets"][] = [
                "id" => $value["id"],
                "company" => "$company",
                "city" => "$city",
                "date_s" => $value['date_s'],
                "date_e" => $value["date_e"]
            ];
        }
        echo (json_encode($data));
    }
    //..........................................................
    public function addticket()
    {
            $city=$_POST['city_id'] ??  "";
            $company=$_POST['company_id'] ??  "";
            $date_s=$_POST['date_s'] ??  "";
            $date_e=$_POST['date_e'] ??  "";
            if ($this->validateId($city) && $this->validateId($company)){
            $data=[
               'city_id'=>$city,
               'company_id'=>$company,
               'date_s'=>$date_s,
               'date_e'=>$date_e
            ];
            $results=$this->ticket->addTicket($data);
            echo json_encode($results);
        }}
        //.....................................................
    public function updateticket($id)
    {   if ($this->validateId($id)) {

            if ($this->ticket->getTicketbyid($id)) {
         $city=$_POST['city_id'] ??  "";
         $company=$_POST['company_id'] ??  "";
         $date_s=$_POST['date_s'] ??  "";
         $date_e=$_POST['date_e'] ??  "";
         $data=[
            'city_id'=>$city,
            'company_id'=>$company,
            'date_s'=>$date_s,
            'date_e'=>$date_e
         ];
        $results=$this->ticket->updateTicket($id,$data);
        
         echo json_encode($results);}
         else{
                $response["status"] = false;
                echo json_encode($response);
         }
        }
         
      }
    
    //.................................................
    public function deleteticket($id)
    {    if ($this->validateId($id)) {
        if($this->ticket->getTicketbyid($id)){
       
       $result= $this->ticket->deleteTicket($id);
       
       echo json_encode($result);} 
       else{
                $response["status"] = false;
                echo json_encode($response);
        }
        }
    }
   
      //....................................................
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
?>