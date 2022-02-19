<?php
namespace App\Lib\Interfaces;

interface QueryBuilderInterface {
    public function table(string $table):QueryBuilderInterface;
    public function select(string $cols):QueryBuilderInterface;
    public function where(string $where):QueryBuilderInterface;
    public function limit(int $from, int $length):QueryBuilderInterface;
    public function update():QueryBuilderInterface;
    public function set(string $query):QueryBuilderInterface;
    public function delete(string $table):QueryBuilderInterface;
    public function createTable(string $table , array $columns):string;
    public function insert(array $items):string;
    public function truncate():string;
    public function get():string;
}
