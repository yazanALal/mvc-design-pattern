<?php

namespace hotel_m;

class Hotel_model{
private $db;
 public function __construct($db){
     $this->db=$db;
    }

    public function getHotels()
    {
        return $this->db->get('hotels');
    }

    public function getHotel($id)
    {     $this->db->where('id',$id);
        return $this->db->get('hotels');
    }
   
    public function getHotelByCityId($id)
    {
        return $this->db->where('city_id',$id)->get('hotels');
    }

    public function getHotelname($id,$colume)
    {     $this->db->where('id',$id);
        return $this->db->getValue('hotels',$colume);
    }

    public function insertHotel($data)
    { $insert=$this->db->insert('hotels',$data);
    if($insert)
    {
        $response = ['status' => true,
            'message' => 'hotel was added'];
        return $response;
    } else {
        $response = ['status' => false,
            'message' => 'failed to add hotel: ' . $this->db->getLastError()];
        return $response;
    }
    }

    public function updateHotel($id,$data)
    {     $this->db->where('id',$id);
       $update=$this->db->update('hotels',$data);
       if($update)
       {
        $response = [ 'status' => true,
        'message' => 'hotel was updated'];
       return $response;
   } else {
       $response = ['status' => false,
        'message' => 'update failed : ' . $this->db->getLastError()];
       return $response;
   }
        
    }
    
    public function deleteHotel($id)
    {   $this->db->where('id',$id);
       $delete= $this->db->delete('hotels');
      if($delete)
      {
        $response = ['status' => true,
            'message' => 'hotel was deleted'];
        return $response;
    } else {
        $response = ['status' => false,
            'message' => 'delete failed : ' . $this->db->getLastError()];
        return $response;
    }
    }


}

?>