<?php
namespace App\Lib\Repository;
use App\Lib\Interfaces\DBInterface;
use App\Lib\Interfaces\FoodRepositoryInterface;
use App\Lib\Interfaces\QueryBuilderInterface;
use App\Lib\Services\FoodManager;
use App\Models\Food;

class FoodRepository implements FoodRepositoryInterface
{
    private  $database;
    private $queryBuilder;
    public function __construct(DBInterface $database,QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        $database->connect();
        $this->database=$database;
    }

    // Can not use query builder here because of a huge query type .
    // ToDo : add a Raw() function to our query builder so the query can be run on other DB's
    public function list():array
    {
        //ToDo : Check if the $this->database is an object of Sqlite
        $expData = "2020_07_25";
        //foods that are dont have ingredients or they are expired
        $expiredAndNotExistQuery = "(SELECT foods.id FROM foods 
                                  join food_has_ingredients on foods.id = food_has_ingredients.food_id 
	                              left join ingredients on food_has_ingredients.ingredient_id = ingredients.id and ingredients.expires_at > '$expData' and ingredients.stock>0
                              where ingredients.id is null)";


        // get foods with a sort order for best before use
        $query = 'SELECT foods.* FROM foods
 left join food_has_ingredients on foods.id = food_has_ingredients.food_id 
 left join ingredients on food_has_ingredients.ingredient_id = ingredients.id
 where foods.id not in ' . $expiredAndNotExistQuery . '
GROUP by foods.id Order by ingredients.best_before DESC';


        $result = $this->database->fetchData($query);
        if($result==false) return false;
        return $result;

    }

    public function getIngredients(Food $food=null): array
    {
        $query = $this->queryBuilder
            ->table('food_has_ingredients')
            ->select('*')
            ->join('left join ingredients on food_has_ingredients.ingredient_id = ingredients.id');
        if(!empty($food))
            $query = $query->where('food_id='.$food->getId());
        $query = $query->get();
        $res = $this->database->fetchData($query);
        return $res;
    }

    public function add(Food $food): bool
    {
        return $this->queryBuilder->table('foods')->insert([[
            $food->getId(),
            $food->getTitle()
        ]]);
    }

    public function find(string $id):Food|bool
    {

        $result = $this->queryBuilder->table('foods')->select( "*")->where('id='.$id)->get();
        $result = $this->database->fetchData($result);
        if($result==false) return false;
        foreach($result as $item)
        {
            return new Food($item['id'],$item['title']);
        }
    }

    public function bought(Food $food)
    {
        $queries = '';
        $ingredients = $this->getIngredients($food);
        foreach($ingredients as $ing)
        {
            if($ing['stock']>0)
                $queries .= $this->queryBuilder->where('')->table('ingredients')->set('stock=' .$ing['stock']-1)->update()->get();
        }
        return $this->database->query($queries);
    }

    //ToDo:Maybe later put this function into ingredients manager
    public function increaseIngredients(int $total)
    {
        $queries = '';
        $ingredients = $this->getIngredients();
        foreach($ingredients as $ing)
        {
            if($ing['stock']==0)
                $queries .= $this->queryBuilder->where('')->table('ingredients')->set('stock=' .$ing['stock']+$total)->update()->get();
        }
        return $this->database->query($queries);
    }

}
