<?php
namespace App\DB;
require "vendor/autoload.php";
use App\Lib\Helpers\Helpers;
use App\Lib\Services\Disk;

new Seed();
class Seed
{

     public function __construct(){
        $query = $this->createUsersTable();
        $query .= $this->createFoodTable();
        $query .= $this->createIngredientsTable();
        $query .= $this->createFoodHasIngredientsTable();
        $query .= $this->createOrderTable();

         $sqlite = new \App\Lib\Services\SQLite();
         $sqlite->connect();
         $sqlite->query($query);
        $this->seed();
    }

    private function createUsersTable()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $query = $queryBuilder->createTable("users",
            [
                "id INTEGER PRIMARY KEY",
                "name TEXT NOT NULL",
                "last_name TEXT not null"
            ]);
        return $query;
    }

    private function createIngredientsTable()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $query = $queryBuilder->createTable("ingredients",
            [
                "id INTEGER PRIMARY KEY",
                "title TEXT NOT NULL",
                "best_before DATETIME not null",
                "expires_at DATETIME not null",
                "stock INTEGER NOT NULL"
            ]);
        return $query;
    }

    private function createFoodTable()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $query = $queryBuilder->createTable("foods",
            [
                "id INTEGER PRIMARY KEY",
                "title TEXT NOT NULL"
            ]);
        return $query;
    }

    private function createFoodHasIngredientsTable()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $query = $queryBuilder->createTable("food_has_ingredients",
            [
                "id INTEGER PRIMARY KEY",
                "food_id INTEGER NOT NULL",
                "ingredient_id INTEGER NOT NULL",
            ]);

        return $query;
    }

    private function createOrderTable()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $query = $queryBuilder->createTable("orders",
            [
                "id INTEGER PRIMARY KEY",
                "food_id INTEGER NOT NULL",
                "user_id INTEGER NOT NULL",
            ]);
        return $query;
    }

    private function seed($number=100)
    {
        $disk = new Disk();
        //Ingredients Data :
        $ingredients = $disk->read('App/DB/ingredients.json');
        $ingredients = str_replace('-','_',$ingredients);
        $ingredients = json_decode($ingredients);
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();

        // Foods Data :
        $foods = $disk->read('App/DB/foods.json');
        $foods = json_decode($foods);

        $foodHasIngredients = []; // insert this food ingredients in another variable for later queries
        array_map(function($item) use (&$foodHasIngredients){
            static $i=1;
            $item->id = $i;
            $foodHasIngredients[] = [
                'food_id' => $i,
                'items' =>$item->ingredients
                ];
            unset($item->ingredients); // we dont need it on queries
            $i++;
        },$foods->recipes);

        // Food Has Ingredients
        $sqlite = new \App\Lib\Services\SQLite();
        $sqlite->connect();

        $query = $queryBuilder->table('ingredients')->insert($ingredients->ingredients);
        $query .= $queryBuilder->table('foods')->insert($foods->recipes);
        $sqlite->query($query);

        $foodHasIngredientsForTable = [];
        foreach($foodHasIngredients as $foodI){
            foreach($foodI['items'] as $ing){
                $query = $queryBuilder->select('*')->table('ingredients')->where('title="'.$ing.'"')->get();
                $data = $sqlite->fetchData($queryBuilder->table('ingredients')->select('*')->get());
                if(!empty($data)) {
                    $foodHasIngredientsForTable[] = [
                        'food_id' => $foodI['food_id'],
                        'ingredient_id' => $data[0]['id']
                    ];
                }
            }
        }

        $query = $queryBuilder->table('food_has_ingredients')->insert($foodHasIngredientsForTable);

        $sqlite->query($query);
    }

}
