<?php
namespace App\Lib\Interfaces;

interface FileSystemInterface
{
    public function read(string $path);
    public function listFiles(string $path):bool|array;
}
