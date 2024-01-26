<?php
namespace admin_c;


class Admin_controller{

    private $admin;

    public function __construct($admin){
        $this->admin=$admin;
    }
    
    public function showAdmins()
    { 
        $data=array();
        $data["status"]=true;
        $data["admins"] = $this->admin->getadmins();
        echo(json_encode($data));

    }
   
// log in function 
    public function logIn()
    {
        $email=$_POST["email"] ?? "";
        $password=$_POST["password"] ?? "";
        if($this->validatepassword($password)  && $this->validateEmail($email))
        { 
            // checking if password and email are true 
           $admin=$this->admin->getAdmin($email, $password);

           if($admin>0){
            // add card to db
                $card=$this->generateCard(8);
                $data=[
                    "card"=>$card
                ];
                $edit=$this->admin->editAdminLogin($email, $password, $data);
                $response=[$edit,"card"=>$card];
                echo json_encode($response);
           }
           else{
            $response=["status"=>false,"msgErr"=> "email does not exist sign up if you dont have an account or password wrong"];
            echo json_encode($response);
           }

        }
    }
//signup function add new admin by insert email , password and name
    public function signUp()
    {
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $name=$_POST["name"]?? "" ;
         if($this->validateName($name) && $this->validatepassword($password)  && $this->validateEmail($email)){
            $data = [
                'name' => $name,
                'password'=>$password,
                'email' => $email,
            ];

            $admin=$this->admin->addAdmin($data);
            echo json_encode($admin);
        }

    }
//signOut function delete card by putting null instead of its value
    public function signOut()
    {
        $headers = getallheaders();
        $card = (string)$headers["card"];
        $data=[
            "card"=>null
        ];

        $edit = $this->admin->editAdminLogOut($card, $data);
        echo json_encode($edit);
    }

    public function editAdmins(){
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $name = $_POST["name"] ?? "";
        $id=$_GET["id"]?? "";
        if ($this->validateName($name) && $this->validatepassword($password)  && $this->validateEmail($email) && $this->validateId($id)) {
            if ($this->admin->getAdminbyid($id)) {
                $data = [
                    'name' => $name,
                    'password' => $password,
                    'email' => $email,
                ];

                $update = $this->admin->editAdmin($id, $data);
                echo json_encode($update);
            }else{
                    $response["status"] = false;
                    echo json_encode($response);
            }
        }
    }
// generate function  it generat random characters and return the value
    public function generateCard($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $Card = '';

        $charactersLength = strlen($characters);
        
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, $charactersLength - 1);
            $Card .= $characters[$randomIndex];
        }

        return $Card;
    }
// verify function by checking if card in db
    public function verifyCard()
    {
        $headers = getallheaders();
        if (isset($headers['card'])) {
            $card = (string)$headers["card"];
            $verify = $this->admin->getAdminLogIn($card);
            if ($verify > 0) {
                return true;
            } else {
                return false;
            }
        }
       else{
        return false;
       } 
       
    }

    public function deleteAdmins(){
        $id = $_GET["id"];
        if ($this->validateId($id)) {
            if ($this->admin->getAdminbyid($id)) {
            $delete = $this->admin->deleteadmin($id);
            echo json_encode($delete);
            } else {
                    $response["status"] = false;
                    echo json_encode($response);
                }
        }
    }

    public function test_input($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    public function validateName($name)
    {
        $response = array();
        if (empty($name)) {
            $response['msgErr'] = 'name is requird';
            echo json_encode($response);
        } else {
            $name = $this->test_input($name);
            if ((!preg_match("/^[a-zA-Z-' ]*$/", $name))) {
                $response['Name Error'] = 'Name  should be  only letters and white space allowed';
                echo json_encode($response);
            } else {
                return true;
            }
        }
    }
   
    public function validateEmail($email)
    {
        $email = $this->test_input($email);
        if(empty($email)){
            $emailErr["msgErr"]= ["status"=>false];
            echo json_encode($emailErr);
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            return true;
        } else {
            $emailErr = ["status" => false, 'Email' => 'Invalid email format '];
            echo json_encode($emailErr);
        }
    }

    public function validatePassword($email)
    {
        if (empty($_POST["password"])) {
            $passerr ["msgErr"]= "pass is required";
            echo json_encode($passerr);
           
        } else if (strlen($_POST["password"]) < 6) {
            $passerr["msgErr"] =  "the password word should be more than 6 characters";
            echo json_encode($passerr);
        } else {
            $password = $this->test_input($_POST["password"]);
            return true;
        }

    }

    function validateId($id)
    {
        $response = array();

        if (is_numeric($id)) {
            return true;
        } else {
            $response["msgErr"] = "id should be integer number";
            echo json_encode($response);
        }
    }
}