<?php
namespace App\Lib\Helpers;
class Faker{

    public function generateFakeArray(array $keys): array
    {
        $fakeArray = [];
        foreach($keys as $key){
            $fakeArray[$key] = $this->data($key);
        }
        return $fakeArray;
    }

    private function data($key){
        //Check The Keys and create related data
        // ToDo : Need to use adapter pattern here , maybe keys/strategies are different on future
        return match ($key) {
            "phone number" => rand(0, 99999),
            "birthday" => rand(1900, 2020) . '/' . rand(1, 12) . '/' . rand(1, 31),
            "address" => Helpers::generateRandomString(100),
            default => Helpers::generateRandomString(),
        };
    }
}
