<?php

    namespace Models;
    use \Illuminate\Database\Eloquent\Model as Eloquent;

    class User extends Eloquent{

        protected $table = 'users';
        protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
        protected $fillable =  ['username', 'email', 'password', 'active'];    
        
    }