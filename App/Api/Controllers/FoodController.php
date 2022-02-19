<?php
namespace App\Api\Controllers;

use App\Lib\Repository\FoodRepository;

class FoodController
{
    private $foodManager;
    public function __construct(FoodRepository $foodManager)
    {
        $this->foodManager=$foodManager;
    }

    //ToDo : send outputs into a spearated resource layer
    public function list($request)
    {
        $foodList = $this->foodManager->list();
        header('Content-Type: application/json; charset=utf-8');
        print json_encode($foodList);
    }
}
