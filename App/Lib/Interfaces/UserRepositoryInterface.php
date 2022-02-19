<?php
namespace App\Lib\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function add(User $user): void;
    public function find(string $id):User|bool;
}
