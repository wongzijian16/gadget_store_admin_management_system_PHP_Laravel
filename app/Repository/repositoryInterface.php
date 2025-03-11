<?php

namespace App\Repository;

interface repositoryInterface {

    public function findUser($id);

    public function getAllUser();

    public function createUser($info);

    public function updateUser($id, $info);

    public function deleteUser($id);
}
