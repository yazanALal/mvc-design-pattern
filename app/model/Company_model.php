<?php

namespace company_m;

class Company_model{

    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCompany($id=null)
    {
        if ($id!==null){
            $this->db->where("id", $id);
            return $this->db->get("companies");    
        }
        else{
            return $this->db->get("companies");
        }
    }  
    public function getCompanyValue($id)
    {
        $this->db->where("id", $id);
        return $this->db->getValue("companies", "name");
    }

    public function insertcompanies($data)
    {
        if($this->db->insert('companies', $data)){
            $response = ['status'=>true,
                        'message' => 'company was added successfully'];
            return $response;
        }
        else{
            $response=['status'=>false,
                    'message'=>'add was failed : '. $this->db->getLastError()];
            return $response;
        }
    }

    public function updateCompanies($data, $id)
    {   
        $this->db->where("id", $id);
        if($this->db->update("companies", $data)){

            $response = ['status'=>true,
                        'message' => 'company was updated'];
            return $response;
        }
        else{
            $response=['status'=>false,
                      'message'=>'update failed : '. $this->db->getLastError()];
            return $response;
        }
    }

    public function deleteCompanies($id)
    {
        $this->db->where("id", $id);
        if($this->db->delete('companies')){

            $response = ['status'=>true,
                        'message' => 'company was deleted'];
            return $response;
        }
        else{

            $response = ['status'=>false,
                        'message' => 'delete failed : ' . $this->db->getLastError()];
            return $response;
        }
    }
}

?>