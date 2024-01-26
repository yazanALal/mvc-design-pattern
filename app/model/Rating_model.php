<?php

namespace rating_m;

class Rating_model {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
//...................................................................
    public function getRatings($id=null)
    {
        if ($id!==null){
            $this->db->where("id", $id);
            
            return  $this->db->get("ratings");
            
        }
        else{
            return  $this->db->get("ratings");
        }
    }

    //.....................................................................
    public function getRatingbyid($customer_id,$hotel_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('hotel_id', $hotel_id);
        return $this->db->get('ratings');
    }

//.....................................................................
    public function getComment(){
        $comments = $this->db->getValue("ratings","comment");
        return $comments;
    }     
//...........................................................................................    
    public function getStars(){
        $stars = $this->db->getValue("ratings","star");
        return $stars;
    }
//...........................................................................................
    public function insertRatings($data)
    {
        $rating=$this->db->insert('ratings', $data);
        if ($rating) {
            $response = ['status'=>true,
                        'message' => 'rating was added'];
            return $response;
        } else {
            $response = ['status'=>false,
                        'message' => 'failed to add rating : ' . $this->db->getLastError()];
            return $response;
        }
    }
//...................................................................................................
    public function updateRatings($data, $id)
    {
        $this->db->where("id", $id);
        if ($this->db->update("ratings", $data)) {
            $response = ['status'=>true,
                        'message' => 'rating was updated'];
            return $response;
        } else {
            $response = ['status'=>false,
                        'message' => 'update failed : ' . $this->db->getLastError()];
            return $response;
        }
    }
//....................................................................................................
    public function deleteRatings($id)
    {
        $this->db->where("id", $id);
        if ($this->db->delete("ratings")) {
            $response = [ 'status'=>true,
                          'message' => 'rating was deleted'];
            return $response;
        } else {
            $response = [ 'status'=>false,
                        'message' => 'delete failed : ' . $this->db->getLastError()];
            return $response;
        }
    }
}
//  THE END



?>