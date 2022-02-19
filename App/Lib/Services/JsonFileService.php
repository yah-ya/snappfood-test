<?php
namespace App\Lib\Services;

use App\Lib\Helpers\Helpers;

class JsonFileService
{
    private $disk;
    public function __construct()
    {
        $this->disk = new Disk();
    }

    public function read(string $filePath)
    {
        return json_decode($this->disk->read($filePath));
    }



}
