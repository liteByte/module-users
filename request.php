<?php

require 'start.php';
use Controllers\Users;
use Helpers\Helpers as Helper;

$data = json_decode(file_get_contents('php://input'), true);

$method = $data['method'];

switch($method) {
    case "REGISTER":
        registerUsers($data);
        break;
    case "LOGIN":
        echo "LOGIN";
        break;
    default:
        echo "No match!";
        break;
}


function registerUsers($data){

    $captcha = $data['captcha'];

    if(!isset($captcha) && empty($captcha)){
        Helper::sendResponse('400',  "Error in Captcha, try again");
    }

    if(!Helper::validateReCaptcha($captcha)){
        Helper::sendResponse('400',  "Error in Captcha, try again");
    }


    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];


    if(empty($username) || empty($password) || empty($email)){
        Helper::sendResponse('400',  "Data incomplete");
    }

    $result_validate = Helper::validateData($username, $email);
    if($result_validate){
        if(!Users::verifyExist($result_validate[0], $result_validate[1])){
            Users::create_user($result_validate[0] ,$result_validate[1], $password);
        }else{
            Helper::sendResponse('400',  "User or email already registered", "try again");
        }
    }
    Helper::sendResponse('400',  "Error in data entered");
}


