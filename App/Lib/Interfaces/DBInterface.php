<?php
namespace App\Lib\Interfaces;

interface DBInterface
{
    public function connect();
    public function query(string $query);
    public function getTables():array;
    public function fetchData(string $query):array;
}
