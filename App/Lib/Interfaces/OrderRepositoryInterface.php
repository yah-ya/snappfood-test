<?php
namespace App\Lib\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function add(Order $order): void;
    public function find(string $id):Order|bool;
}
