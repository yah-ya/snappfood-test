<?php
namespace App\Lib\Services;
use App\Lib\Interfaces\OrderRepositoryInterface;
use App\Models\ORder;

class OrderManager {
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository){
        $this->orderRepository=$orderRepository;
    }
    public function add(Order $user): void
    {
        $this->orderRepository->add($user);
    }
    public function find(string $id):Order
    {
        return $this->orderRepository->find($id);
    }
}
