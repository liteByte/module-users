<?php

$data = json_decode(file_get_contents('php://input'), true);


$method = $data['method'];

die($method);

$username = $data['username'];
$password = $data['password'];


if(empty($username) || empty($password) ){
    setResponse(404, "Data incompled");
}

require 'start.php';
use Controllers\Users;

$user = Users::create_user($username ,$password, $username);

echo $user;




function setResponse($error_code = null, $msg = null){
    $error_code = ($error_code != '' ? $error_code: 404);
    header('Content-type: application/json');
    http_response_code($error_code);
    echo  $result_json  =  json_encode(array('error' => $msg ));
    exit;

}

