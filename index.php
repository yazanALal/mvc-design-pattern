<?php

spl_autoload_register(function ($class) {
    
    $class = explode("\\", $class);

    $class = end($class); 

  
    if (file_exists(__DIR__ . "/lib/db/" . $class . ".php")) {
        require_once __DIR__ . "/lib/db/" . $class . ".php";
    }

    if (file_exists(__DIR__ . "/app/model/" . $class . ".php")) {
        require_once __DIR__ . "/app/model/" . $class . ".php";
    }

    if (file_exists(__DIR__ . "/app/controller/" . $class . ".php")) {
        require_once __DIR__ . "/app/controller/" . $class . ".php";
    }

    if (file_exists(__DIR__ . "/config/" . $class . ".php")) {
        require_once __DIR__ . "/config/" . $class . ".php";
    }
});
$config = require "config/config.php";

$db = new MysqliDb(
    $config['db_host'],
    $config['db_user'],
    $config['db_password'],
    $config['db_name']
);

$request = $_SERVER['REQUEST_URI'];
define("BASE_PATH", "/");




use city_m\City_model;
use city_c\City_controller;
$city = new City_model($db);
$cityC = new City_controller($city);


use admin_m\Admin_model;
use admin_c\Admin_controller;
$admin = new Admin_model($db);
$adminC = new Admin_controller($admin);

use customer_m\Customer_model;
use customer_c\Customer_Controller;
$customer= new Customer_model($db); 
$customerC= new Customer_Controller($customer);


use hotel_m\Hotel_model;
use hotel_c\Hotel_controller;
$hotel = new Hotel_model($db);
$hotelC= new Hotel_controller($hotel ,$city);


use rating_m\Rating_model;
use rating_c\Rating_controller;
$rating= new Rating_model($db);
$ratingC= new Rating_controller($rating, $customer, $hotel);//$hotelC

use company_m\Company_model;
use company_c\Company_controller;
$company= new Company_model($db);
$companyC=new Company_controller($company);

use ticket_m\Ticket_model;
use ticket_c\Ticket_controller;
$ticket = new Ticket_model($db);
$ticketC = new Ticket_controller($ticket, $company, $city);

use booking_m\booking_model;
use booking_c\booking_controller;
$booking = new Booking_model($db);
$bookingC = new Booking_controller($booking, $customer, $hotel, $ticket);

if (!($adminC->verifyCard())) {
    switch ($request) {
        case BASE_PATH:
            $adminC->logIn();
            break;
        case BASE_PATH . "signUp":
            $adminC->signUp();
            break;
        default:

            $response = ['message' => 'no such an action'];
            echo json_encode($response);
            break;
    }
}
else{
switch ($request) {

    case BASE_PATH:
        $bookingC->showBookings();
        break;
    case BASE_PATH."showAdmins":
        $adminC->showAdmins();
        break;
    case BASE_PATH."showCities":
        $cityC->showCities();
        break;
    case BASE_PATH."showCompanies":
        $companyC->showCompanies();
        break;
    case BASE_PATH."showCustomers":
        $customerC->showCustomers();
        break;
    case BASE_PATH. "showHotels":
        $hotelC->showHotels();
        break;
    case BASE_PATH. "showRatings":
        $ratingC->showRatings();
        break;
    case BASE_PATH. "showTickets":
        $ticketC->showTickets();
        break;
    case BASE_PATH . "addRating":
        $ratingC->insertRatings();
        break;    
    case BASE_PATH . "editRating?id=" .  $_GET['id']:
        $ratingC->updateRating($_GET['id']);
        break;
    case BASE_PATH . "deleteRating?id=" . $_GET['id']:
        $ratingC->deleteRating($_GET['id']);
        break;
    case BASE_PATH . "logOut":
        $adminC->signOut();
        break;
    case BASE_PATH . "editAdmin?id=" . $_GET['id']:
        $adminC->editAdmins();
        break;
    case BASE_PATH . "deleteAdmin?id=" . $_GET['id']:
        $adminC->deleteAdmins();
        break;
    case BASE_PATH . "addBooking":
        $bookingC->insertBooking();
        break;
    case BASE_PATH . "editBooking?id=" . $_GET['id']:
        $bookingC->updatebooking();
        break;
    case BASE_PATH . "deleteBooking?id=" . $_GET['id']:
        $bookingC->deleteBooking();
        break;

    case BASE_PATH . "addCity":
        $cityC->insertCity();
        break;
    case BASE_PATH . "editCity?id=" . $_GET['id']:
        $cityC->updateCity();
        break;
    case BASE_PATH . "deleteCity?id=" . $_GET["id"]:
        $cityC->deleteCity();
        break;

    case BASE_PATH . "addcompany":
        $companyC->insertCompany();
        break;
    case BASE_PATH . "editCompany?id=" .  $_GET['id']:
        $companyC->updateCompany($_GET['id']);
        break;
    case BASE_PATH . "deleteCompany?id=" . $_GET['id']:
        $companyC->deletecompany($_GET['id']);
        break;
    
    case BASE_PATH."addcustomer":
        $customerC->insertCustomer();
        break;
    case BASE_PATH . "editcustomer?id=" . $_GET['id']:
        $id=$_GET['id'];
        $customerC->updateCustomer($id);
        break;
    case BASE_PATH . "deletecustomer?id=" . $_GET["id"]:
        $id=$_GET['id'];
        $customerC->deleteCustomers($id);
        break;
            //Actions Hotels.....................................................
        case BASE_PATH . "addhotel":
            $hotelC->addhotel();
            break;

        case BASE_PATH . "edithotel?id=" . $_GET['id']:
            $id = $_GET['id'];
            $hotelC->updatehotel($id);
            break;

        case BASE_PATH . "deletehotel?id=" . $_GET["id"]:
            $id = $_GET['id'];
            $hotelC->deletehotel($id);
            break;
            //Action Ticket........................................................
        case BASE_PATH . "addticket":
            $ticketC->addticket();
            break;

        case BASE_PATH . "editticket?id=" . $_GET['id']:
            $id = $_GET['id'];
            $ticketC->updateticket($id);
            break;

        case BASE_PATH . "deleteticket?id=" . $_GET["id"]:
            $id = $_GET['id'];
            $ticketC->deleteticket($id);
            break; 

    default :

        $response = ['message' => 'no such an action'];
        echo json_encode($response);
        break;


    }
}

?>

