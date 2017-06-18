<?php

namespace Helpers;


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
}
