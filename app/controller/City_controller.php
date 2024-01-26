<?php

namespace city_c;

class City_controller
{
    private $city;

    public function __construct($city)
    {
        $this->city = $city;
    }

    public function showCities()
    {
        $data = array();
        $data["status"] = true;
        $data["cities"] = $this->city->getCities();
        echo (json_encode($data));
    }

    public function insertCity()
    {
        $name = $_POST['name'] ??  "";
        $country = $_POST['country'] ??  "";
        
        if($this->validateName($name) && $this->validateName($country)){
            $data = [
                "name" => "$name",
                "country" => "$country",
            ];
            $insert = $this->city->insertcities($data);
            echo json_encode($insert);
        }
        
    }

    public function updateCity()
    {

        $name = $_POST['name'] ??  "" ;
        $country = $_POST['country'] ?? "";
        $data=array();

        if ($this->validateName($name)) {
            $data['name'] = $name;
        }
        
        if ($this->validateName($country)) {
            $data['country'] = $country;
        } 

        if (!empty($data)) {
            $id = $_GET["id"];
            if($this->validateId($id)){
                if ($this->city->getCitybyid($id)) {
                $update = $this->city->updateCities($data, $id);
                echo json_encode($update);
                } else {
                        $response["status"] = false;
                        echo json_encode($response);
                    }
            }
        }  
    }

    public function deleteCity()
    {
        $id = $_GET["id"];
        if ($this->validateId($id)) {
            if ($this->city->getCitybyid($id)) {
            $delete = $this->city->deleteCities($id);
            echo json_encode($delete);
            } else {
                    $response["status"] = false;
                    echo json_encode($response);
                }
        }
    }
    //validation functions
    function test_input($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    function validateName($name)
    {
        $response=array();
        if (empty($name)) {
            $response['msgErr'] ='name is requird';
            echo json_encode($response);
        } else {
            $name = $this->test_input($name);
            if ((!preg_match("/^[a-zA-Z-' ]*$/", $name))) {
                $response['msgErr'] = 'only letters and white space allowed';
                echo json_encode($response);
            } else {
                return true;
            }
        }
    }

    function validateId($id)
    {
        $response=array();

        if(is_numeric($id)){
            return true;
        }
        else{
            $response["msgErr"]="id should be integer number";
            echo json_encode($response);
        }
    }
}
