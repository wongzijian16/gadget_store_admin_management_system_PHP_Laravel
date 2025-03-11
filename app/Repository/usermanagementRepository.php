<?php

namespace App\Repository;
use App\Models\User;

class usermanagementRepository implements repositoryInterface {
    public function findUser($id){
        return User::find($id);
    }

    public function getAllUser(){
        return User::all();
    }

    public function createUser($info){
        return User::create($info);
    }

    public function updateUser($id, $info){
        return $this->findUser($id)->update($info);
    }

    public function deleteUser($id){
        return User::destroy($id);
    }
}