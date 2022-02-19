<?php
namespace App\Lib\Services;

use App\Lib\Interfaces\FileSystemInterface;

class Disk implements FileSystemInterface
{

    public function listFiles($path = 'DB/'): bool|array
    {
        return array_filter(scandir($path), function($item) {
            return $item[0] !== '.';
        });
    }

    public function read(string $path): bool|string
    {
         return file_get_contents($path);
    }

}
