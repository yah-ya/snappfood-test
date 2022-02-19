<?php
namespace App\Lib\Services;
use App\Lib\Interfaces\FoodRepositoryInterface;
use App\Models\Food;

class FoodManager {
    private $foodRepository;

    public function __construct(FoodRepositoryInterface $foodRepository){
        $this->foodRepository=$foodRepository;
    }
    public function add(Food $food): void
    {
        $this->foodRepository->add($food);
    }
    public function find(string $id):User
    {
        return $this->foodRepository->find($id);
    }

    public function list():array
    {
        return $this->foodRepository->list();
    }

    public function ingredients():array
    {
        return $this->foodRepository->getIngredients();
    }

    public function bought(Food $food)
    {
        $ingredients = $this->foodRepository->getIngredients();
        return $this->foodRepository->bought($ingredients);
    }
}
