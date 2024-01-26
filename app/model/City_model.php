<?php

namespace city_m;

class City_model{
    private $db;
    

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCities()
    {
        return $this->db->get("cities");
    }

    public function getCitybyid($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('cities');
    }

    public function getCityValue($id)
    {
        $this->db->where("id",$id);
        return $this->db->getValue("cities","name");
    }

    public function insertCities($data)
    {
        $city=$this->db->insert('cities', $data);
        if($city){
            $response = [
                'status' => true,
                'message' => 'City was added'];
            return $response;
        }
        else{
            $response = [
                'status' => false,
                'message' => 'failed to add city: ' . $this->db->getLastError()];
            return $response;
        }
    }

    public function updateCities($data, $id)
    {
        $this->db->where("id", $id);
        if($this->db->update("cities", $data)){
                $response = [
                'status' => true,
                'message' => 'City was updated'];
                return $response;
            }
        else{
            $response=[
                'status' => false,
                'message'=>'update failed : '. $this->db->getLastError()];
            return $response;
        }
    }

    public function deleteCities($id)
    {
        $this->db->where("id", $id);
        if($this->db->delete('cities')){
            $response = [
                'status' => true,
                'message' => 'City was deleted'];
            return $response;
        }
        else{
            $response = [
                'status' => false,
                'message' => 'delete failed : ' . $this->db->getLastError()];
            return $response;
        }
    }
    
}

?>