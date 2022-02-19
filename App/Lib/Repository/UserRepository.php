<?php
namespace App\Lib\Repository;
use App\Lib\Interfaces\DBInterface;
use App\Lib\Interfaces\QueryBuilderInterface;
use App\Lib\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private  $database;
    private $queryBuilder;
    public function __construct(DBInterface $database,QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        $database->connect();
        $this->database=$database;
    }

    public function add(User $user): void
    {
        $query = $this->queryBuilder->table('users')->insert([[
            'id'=>$user->getId(),
            'name'=>$user->getFirstName(),
            'last_name'=>$user->getLastName()
        ]]);
        $this->database->query($query);
    }

    public function find(string $id):User|bool
    {

        $result = $this->queryBuilder->table('users')->select( "*")->where('id='.$id)->get();
        $result = $this->database->fetchData($result);
        if($result==false) return false;
        foreach($result as $item)
        {
            return new User($item['id'],$item['name'],$item['last_name']);
        }
    }
}
