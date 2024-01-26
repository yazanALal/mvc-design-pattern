<?php

namespace customer_m;

class Customer_model
{
    private $db;
    public function __construct($db)
    {
        $this->db=$db;
    }

    public function getCustomer()
    {
        return $this->db->get('customers');
    }

    public function getCustomerbyid($id)
    {     $this->db->where('id',$id);
        return $this->db->get('customers');
    }

    public function getCustomerValue($id)
    {
        $this->db->where("id", $id);
        return $this->db->getValue("customers", "name");
    }
    
    public function addCustomer($data)
    {
        $customer = $this->db->insert('customers', $data);
        if ($customer) {
            $response = [
                'status' => true,
                'message' => 'Customer was added'
            ];
            return $response;
        } else {
            $response = [
                'status' => false,
                'message' => 'failed to add Customer: ' . $this->db->getLastError()
            ];
            return $response;
        }
    }
    public function editCustomer($id, $data)
    {
        $this->db->where("id", $id);
        if ($this->db->update("customers", $data)) {
            $response = [
                'status' => true,
                'message' => 'Customer was updated'
            ];
            return $response;
        } else {
            $response = [
                'status' => false,
                'message' => 'update failed : ' . $this->db->getLastError()
            ];
            return $response;
        }
    }
    public function deleteCustomer($id)
    {
        $this->db->where("id", $id);
        if ($this->db->delete('customers')) {
            $response = [
                'status' => true,
                'message' => 'Customer was deleted'
            ];
            return $response;
        } else {
            $response = [
                'status' => false,
                'message' => 'delete failed : ' . $this->db->getLastError()
            ];
            return $response;
        }
    }
}
