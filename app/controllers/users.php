<?php


namespace Controllers;
use Models\User;
use \Illuminate\Database\QueryException as exc;


class Users{

    const FIELD_USERNAME = "username";
    const FIELD_EMAIL = "email";
    const FIELD_PASSWORD = "password";
    const FIELD_ACTIVE = "active";


    public static function create_user($username, $email, $password){


        try{
            $result = User::create([
                self::FIELD_USERNAME  => $username,
                self::FIELD_EMAIL      => $email,
                self::FIELD_PASSWORD   => $password,
                self::FIELD_ACTIVE     => 1
            ]);

            if($result->getKey() != 0){
                return $result->getKey();
            }

        }catch (exc $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode <> 0){
                die("error: " ."==> ". $errorCode ." ==> ".  $e->getMessage());
            }
        }

        return 0;
    }


    public static function getAll(){
        return  User::get();
    }

    public static function getById($id){
        $result  = User::find($id);
        return $result;
    }


}