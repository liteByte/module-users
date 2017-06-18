<?php


namespace Controllers;
use Models\User;
use Helpers\Helpers as Helper;
use \Illuminate\Database\QueryException as exc;


class Users{

    const FIELD_USERNAME = "username";
    const FIELD_EMAIL = "email";
    const FIELD_PASSWORD = "password";
    const FIELD_ACTIVE = "active";
    const VALUE_ACTIVE = 1;

    public static function create_user($username, $email, $password){

        //TODO secure
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try{
            $result = User::create([
                self::FIELD_USERNAME  => $username,
                self::FIELD_EMAIL      => $email,
                self::FIELD_PASSWORD   => $hashed_password,
                self::FIELD_ACTIVE     => self::VALUE_ACTIVE
            ]);

            if($result->getKey() != 0){
                Helper::sendResponse('200', $result->getKey());
            }

        }catch (exc $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode <> 0){
                $string  = "error: " ."==> ". $errorCode ." ==> ".  $e->getMessage();
                Helper::sendResponse('400', $string);
            }
        }
        return true;
    }


    public static function verifyExist($username, $email){
        $result = User::where( self::FIELD_USERNAME,  $username)
            ->orWhere(self::FIELD_EMAIL, $email)
            ->get();
        if($result->count() != 0 ){
            return true;
        }
        return false;
    }

    public static function login_user($username, $password){
        $user= User::where( self::FIELD_USERNAME,  $username)->get();

        if($user->count() == 0 ){ return false; }

        $user = $user->toArray();

        $username_r = $user[0]['username'];
        $password_r = $user[0]['password'];

        $pass = password_verify($password, $password_r);

        if(!$pass){
            Helper::sendResponse('400', "User or Password invalid");
        }
        
        return $user;
    }

    public static function getAll(){
        return  User::get();
    }

    public static function getById($id){
        $result  = User::find($id);
        return $result;
    }

}