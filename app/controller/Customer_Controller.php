<?php
namespace  customer_c;
class Customer_Controller{
    private $customer;

    public function __construct($customer){
        $this->customer = $customer;

    }

    public function showCustomers()
    {
        $data = array();
        $data["status"] = true;
        $data["customers"] = $this->customer->getCustomer();
        echo (json_encode($data));
    }

    public function insertCustomer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? "";
            $phone = $_POST['phone'] ?? "";
            $gender = $_POST['gender'] ?? "";
            $email = $_POST['email'] ?? "";
            if($this->validateName($name) && $this->validatePhoneNumber($phone) && $this->validateEmail($email))
           { $data = [
                'name' => $name,
                'phone' => $phone,
                'gender' => $gender,
                'email' => $email,
            ];

            $customer=$this->customer->addCustomer($data);
            echo json_encode($customer);
           
            }
        }
    }

    public function updateCustomer($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($this->validateId($id)) {
                    if ($this->customer->getCustomerbyid($id)) {
                        $name = $_POST['name'] ?? "";
                        $phone = $_POST['phone'] ?? "";
                        $gender = $_POST['gender'] ?? "";
                        $email = $_POST['email'] ?? "";
                        if($this->validateName($name) && $this->validatePhoneNumber($phone) && $this->validateEmail($email) && $this->validateId($id))
                        {  $data = [
                            'name' => $name,
                            'phone' => $phone,
                            'gender' => $gender,
                            'email' => $email,
                            ];

                            $customer=$this->customer->editCustomer($id, $data);
                            echo json_encode($customer);
                        }
                
                    }
                else{
                    $response["status"] = false;
                    echo json_encode($response);
                } 
            }
        }
    }
    
    public function deleteCustomers($id) {
        if ($this->validateId($id)) {
            if($this->customer->getCustomerbyid($id)){
            $customer = $this->customer->deleteCustomer($id);
            echo json_encode($customer);
            }
            else{
                $response["status"] = false;
                echo json_encode($response);
            }
        }
    }
    //validate..........................................................
    public function test_input($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    public function validateName($name)
    {
        $response=array();
        if (empty($name)) {
            $response['msgErr'] ='name is requird';
            echo json_encode($response);
        } else {
            $name = $this->test_input($name);
            if ((!preg_match("/^[a-zA-Z-' ]*$/", $name))) {
                $response["status"] = false;
                $response['Name Error'] = 'Name  should be  only letters and white space allowed';
                echo json_encode($response);
            } else {
                return true;
            }
        }
    }
    public function validatePhoneNumber($id){
        if (preg_match('/^[0-9]+$/', $id)) {
            return true;
        } 
        else {
            $phoneError=[
                "status"=>false,
                'Phone number'=> ' must be just a numbers fish'];
            echo json_encode($phoneError);
        }
    }
    public function validateEmail($email){
        $email = $this->test_input($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } 
        else {
            $emailErr=[
                "status"=>false,
                'Email'=> 'Invalid email format '];
            echo json_encode($emailErr);
        }
    }
    public function validateId($id)
    {
        if (is_numeric($id)) {
            return true;
        } else {
            $response["status"] = false;
            $response["Id Error"] = "id should be integer number";
            echo json_encode($response);
        }
    }

}
?>

