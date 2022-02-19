<?php
namespace App\Api\Controllers;

use App\Lib\Repository\FoodRepository;
use App\Lib\Repository\OrderRepository;
use App\Models\Order;
use App\Models\User;

class OrderController
{
    private $orderManager;
    private $foodManager;
    public function __construct(OrderRepository $orderManager,FoodRepository $foodManager)
    {
        $this->orderManager=$orderManager;
        $this->foodManager=$foodManager;
    }


    public function add(User $user,$id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $food = $this->foodManager->find($id);
        if(empty($food)){
            $out = json_encode(['res'=>false,'msg'=>'Food Not Found']);
            print json_encode($out);
        }
        $order = new Order(null,$user->getId(),$id);
        $this->orderManager->add($order);

        //// ToDo : Maybe its better to send these events into an Observer Pattern
        ///  that can listen and do other things after an order is set
        $this->foodManager->bought($food);

        $out = ['res'=>true,'msg'=>'Food Succesfully Bought'];
        print json_encode($out);
    }
}
