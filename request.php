<?php

require 'start.php';
use Controllers\Users;

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
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];

    if(empty($username) || empty($password) || empty($email)){
        setResponse(203, "Data incompled");
    }

    $user = Users::create_user($username ,$password, $email);
    setResponse(200, $user);

}





function setResponse($code = null, $msg = null){
    $code = ($code != '' ? $code: 404);
    header('Content-type: application/json');
    http_response_code($code);
    echo  $result_json  =  json_encode(array('msg' => $msg ));
    exit;

}

