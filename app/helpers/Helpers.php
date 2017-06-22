<?php

namespace Helpers;
include 'Jwt.php';
use JWT;

class Helpers{

    static  $code;
    static $msg = "Error";
    static $secret = "6LdCwyUUAAAAAI7IzSy-9sflwmF0FstQLAN_SO2R";
    public function __construct(){
    }

    Static function sendResponse($code_r = null, $msg_r = null){
        self::$code = ($code_r != '' ? $code_r: 404);
        self::$msg = ($msg_r != '' ? $msg_r: self::$msg );

        header('Content-type: application/json');
        http_response_code(self::$code);
        echo  $result_json  =  json_encode(array('code' => self::$code, 'msg' => self::$msg ));
        exit();
    }

    Static function validateData($username, $email){
        $result = true;

        $email  = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $result =  false;
        }else{
            $username = filter_var($username, FILTER_SANITIZE_STRING);
            $returnValues = [$username];
            $returnValues[] = array_push($returnValues, $email);
        }
        if(!$result){
            return $result;
            exit;
        }
        return $returnValues;
    }

    static function validateReCaptcha($captcha){

        $url = "https://www.google.com/recaptcha/api/siteverify?secret={" . self::$secret . "}&response={$captcha}";
        $verify = file_get_contents($url);
        $captcha_success=json_decode($verify);

        if(!$captcha_success->success){
            self::sendResponse('400',  "Error in Captcha, try again");
        }
        return  true;
    }

    static function createToken($user){

        $secretKey = base64_decode('jwtKey');

        $tokenId    = base64_encode(mcrypt_create_iv(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;             //Adding 10 seconds
        $expire     = $notBefore + 60;            // Adding 60 seconds

        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'nbf'  => $notBefore,        // Not before
            'exp'  => $expire,           // Expire
            'data' => [                  // Data related to the signer user
                'userId'   => $user[0]['id'], // userid from the users table
                'userName' => $user[0]['username'], // User name
            ]
        ];


        $jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        $unencodedArray = ['jwt' => $jwt];
        return json_encode($unencodedArray);
    }

    static function decodeToken($token){
        $secretKey = base64_decode('jwtKey');

        $token = JWT::decode($token, $secretKey, array('HS512'));


    }

    public static function sendemail($email){

        $to = $email;
        $subject = "Recover Password";
        $from = "test@gmail.com";

        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        $headers .= "CC: test@example.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";

        $message =  file_get_contents('http://localhost/module_users/app/helpers/template.html');

        if(!mail($to,$subject,$message, $headers)){
            return false;
        }
        return true;
    }
}
