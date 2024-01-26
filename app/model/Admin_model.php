<?php

namespace admin_m;

class Admin_model{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAdmin($email,$password)
    {
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        $cols = array( "password", "email");
        $this->db->get('admins',null, $cols);
        return $this->db->count;
    }

    public function getAdminLogIn($card)
    {
        $this->db->where("card", $card);
        $this->db->get('admins');
        return $this->db->count;
    }

    public function getAdmins()
    {  
        $cols = array("id","name");
        
        return $this->db->get('admins', null, $cols);
    }
    
    public function getAdminbyid($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('admins');
    }

    public function addAdmin($data)
    {
        $admin = $this->db->insert('admins', $data);
        if ($admin) {
            $response = [
                'status' => true,
                'message' => 'admin was added'
            ];
            return $response;
        } else {
            $response = [
                'status' => false,
                'message' => 'failed to add admin: ' . $this->db->getLastError()
            ];
            return $response;
        }
    }

    public function editAdmin($id, $data)
    {
        $this->db->where("id", $id);
        if ($this->db->update("admins", $data)) {
            $response = [
                'status' => true,
                'message' => 'admin was updated'
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


    public function editAdminLogin($email,$password, $data)
    {
        $this->db->where("email", $email);
        $this->db->where("password", $password);
        if ($this->db->update("admins", $data)) {
            $response = [
                'status' => true,
                'message' => 'LogIn was successfull'
            ];
            return $response;
        } else {
            $response = [
                'status' => false,
                'message' => 'logIn failed : ' . $this->db->getLastError()
            ];
            return $response;
        }
    }

    public function editAdminLogOut($card, $data)
    {
        $this->db->where("card", $card);
        if ($this->db->update("admins", $data)) {
            $response = [
                'status' => true,
                'message' => 'LogOut was successfull'
            ];
            return $response;
        } else {
            $response = [
                'status' => false,
                'message' => 'logOut failed : ' . $this->db->getLastError()
            ];
            return $response;
        }
    }

    public function deleteAdmin($id)
    {
        $this->db->where("id", $id);
        if ($this->db->delete('admins')) {
            $response = [
                'status' => true,
                'message' => 'admin was deleted'
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

?>