<?php
namespace App\Models;
class Order {
    private $id;
    private $userId;
    private $foodId;

    public function __construct($id,$userId,$foodId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->foodId = $foodId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getFoodId()
    {
        return $this->foodId;
    }

}
