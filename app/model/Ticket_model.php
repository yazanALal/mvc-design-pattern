<?php

namespace ticket_m;

class Ticket_model{
    
    private $db;
    public function __construct($db){
     $this->db=$db;
    }
    public function getTickets()
    {
        return $this->db->get('tickets');
    }
    //.................................
    public function getTicketbyid($id)
    {    $this->db->where('id',$id);
        return $this->db->get('tickets');
    }
    //............................................
    public function geticketinfo($id,$colume)
    {     $this->db->where('id',$id);
        return $this->db->getValue('tickets',$colume);
    }
    //...................................
    public function getTicketByCityId($id)
    {
        return $this->db->where('city_id',$id)->get('tickets');
    }
    //..........................................
    public function getTicketByCompanyId($id)
    {
        return $this->db->where('company_id',$id)->get('tickets');
    }
    //....................................
    public function addTicket($data)
    { $insert=$this->db->insert('tickets',$data);
        if ($insert) {
            $response = ['status' => true,
                'message' => 'ticket was added'];
            return $response;
        } else {
            $response = ['status' => false,
                'message' => 'failed to add ticket: ' . $this->db->getLastError()];
            return $response;
        }
    }
    //........................................
    public function updateTicket($id,$data)
    {     $this->db->where('id',$id);
       $update= $this->db->update('tickets',$data);
       if($update)
       {
        $response = ['status' => true,
            'message' => 'ticket was updated'];
        return $response;
    } else {
        $response = ['status' => false,
            'message' => 'update failed : ' . $this->db->getLastError()];
        return $response;
    }
       
    }
    //.....................................
    public function deleteTicket($id)
    {   $this->db->where('id',$id);
        $delete= $this->db->delete('tickets');
        if($delete)
        {
            $response = ['status' => true,
                'message' => 'ticket was deleted'];
            return $response;
        } else {
            $response = ['status' => false,
                'message' => 'delete failed : ' . $this->db->getLastError()];
            return $response;
        }
    }


}



?>