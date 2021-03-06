<?php
use PHPUnit\Framework\TestCase;

class unitTest extends TestCase {

    // check if db is connected
    // check if can do queries
    // check if tables are there
    // check if jsonFileService can find and read json files
    // check if User Manager Finds User
    // Check if Food Manager Finds Food && Food Has Ingredients

    function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    function test_connected_to_db()
    {
        $pdo = (new \App\Lib\Services\SQLite())->connect();
        $this->assertNotNull($pdo);
    }

    function test_can_query()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $query = $queryBuilder->createTable("users",
            [
                "id INTEGER PRIMARY KEY",
                "name TEXT NOT NULL",
                "last_name TEXT not null"
            ]);

        $sqlite = new \App\Lib\Services\SQLite();
        $sqlite->connect();
        $sqlite->query($query);
        $tables = $sqlite->getTables();
        $this->assertEquals(['food_has_ingredients','foods','ingredients','orders','users'],$tables);

        $query = $queryBuilder->table('users')->select('*')->get();

        $users = $sqlite->fetchData($query);
        $this->assertIsArray($users);
    }

    function test_can_add_and_get_users()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $sqlite = new \App\Lib\Services\SQLite();
        $userRepository = new \App\Lib\Repository\UserRepository($sqlite,$queryBuilder);

        $newUser = new \App\Models\User(1,'Yahyya','Taashk','y.t.15132@gmail.com');
        $userRepository->add($newUser);

        $user = $userRepository->find(1);
        $this->assertIsObject($user);
    }

    function test_can_get_foods()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $sqlite = new \App\Lib\Services\SQLite();
        $foodRepo = new \App\Lib\Repository\FoodRepository($sqlite,$queryBuilder);
        $res = $foodRepo->list();
        $this->assertIsArray($res);
    }

    function test_can_get_food_ingredients()
    {
        $queryBuilder = new \App\Lib\Services\SQLiteQueryBuilder();
        $sqlite = new \App\Lib\Services\SQLite();
        $foodRepo = new \App\Lib\Repository\FoodRepository($sqlite,$queryBuilder);

        $food = $foodRepo->find(1);
        $res = $foodRepo->getIngredients($food);
        $this->assertIsArray($res);
    }
}
