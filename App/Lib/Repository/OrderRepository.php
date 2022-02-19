<?php
namespace App\Lib\Repository;
use App\Lib\Interfaces\DBInterface;
use App\Lib\Interfaces\OrderRepositoryInterface;
use App\Lib\Interfaces\QueryBuilderInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    private $database;
    private $queryBuilder;
    public function __construct(DBInterface $database,QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        $database->connect();
        $this->database=$database;
    }

    public function add(Order $order): void
    {
        $query = $this->queryBuilder->table('orders')->insert([[
            'user_id'=>$order->getUserId(),
            'food_id'=>$order->getFoodId()
        ]]);
        $result = $this->database->query($query);
    }

    public function find(string $id):Order|bool
    {

        $result = $this->queryBuilder->table('orders')->select( "*")->where('id='.$id)->get();
        $result = $this->database->fetchData($result);
        if($result==false) return false;
        foreach($result as $item)
        {
            return new Order($item['id'],$item['user_id'],$item['food_id']);
        }
    }
}
