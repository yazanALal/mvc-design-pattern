<?php
namespace hotel_c;
class Hotel_controller
{ private $hotel,$city;
public function __construct($hotel, $city)
    {
        $this->hotel=$hotel;
        $this->city = $city;
    }
    //..............................................................

    public function showHotels()
    {
        $data = array();
        $data["status"] = true;
        $hotels = $this->hotel->gethotels();
        foreach ($hotels as $key => $value) {
            $city = $this->city->getCityValue($value["city_id"]);
            $data["hotels"][] = [
                "id" => $value["id"],
                "name" => $value["name"],
                "phone" => $value['phone'],
                "city" => "$city"
            ];
        
        }
        echo (json_encode($data));
    }
    //..............................................................
    public function addhotel()
    {
             $name=$_POST['name'] ??  "";
            $city=$_POST['city_id'] ??  "";
            $phone=$_POST['phone'] ??  "";
        
     if(($this->validateId($city)) && $this->validateName($name) && $this->validatePhoneNumber($phone))
             {  $data=[
                'name'=>$name,
                 'city_id'=>$city,
                  'phone'=>$phone
                ];
             $results=$this->hotel->insertHotel($data);
            echo json_encode($results);
             }
        }
        //.....................................................
    public function updatehotel($id)
    {    if ($this->validateId($id)) {
            if ($this->hotel->getHotel($id)) {
        $name=$_POST['name'] ??  "";
        $city=$_POST['city_id'] ??  "";
        $phone=$_POST['phone'] ??  "";
      if(($this->validateId($city)) && $this->validateName($name) && $this->validatePhoneNumber($phone))
      {
             $data=[
             'name'=>$name,
             'city_id'=>$city,
             'phone'=>$phone ];
        $results=$this->hotel->updateHotel($id,$data);
        echo json_encode($results);}
       } else {
                $response["status"] = false;
                echo json_encode($response);
            }
        }
    }
    //.................................................
    public function deletehotel($id)
    {  if ($this->validateId($id)) {
        if($this->hotel->getHotel($id)){
        
            $result= $this->hotel->deleteHotel($id);
      
            echo json_encode($result);}
        else{
            $response["status"] = false;
            echo json_encode($response);
            }
        }
    }
    
       //validate.........................................................................
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
                $response["status"] = false;
                $phoneError=['Phone number'=> ' must be just a numbers fish'];
                echo json_encode($phoneError);
            }
        }
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