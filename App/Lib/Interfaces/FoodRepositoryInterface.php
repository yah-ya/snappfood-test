<?php
namespace App\Lib\Interfaces;

use App\Models\Food;

interface FoodRepositoryInterface
{
    public function add(Food $food):bool;
    public function find(string $id):Food|bool;
    public function list():array;
    public function getIngredients(Food $food):array;
//    public function filter(FoodCriteria $criteria);
}
