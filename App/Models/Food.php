<?php
namespace App\Models;

class Food {
    private $id;
    private $title;
    private $ingredients=[];

    public function __construct(int $id,string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
