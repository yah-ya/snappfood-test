<?php

return [
    'OrderManager' => DI\create(\App\Lib\Repository\OrderRepository::class)
        ->constructor(DI\get(\App\Lib\Services\SQLite::class),DI\get(\App\Lib\Services\SQLiteQueryBuilder::class)),

    'FoodManager' => DI\create(\App\Lib\Repository\FoodRepository::class)
    ->constructor(DI\get(\App\Lib\Services\SQLite::class),DI\get(\App\Lib\Services\SQLiteQueryBuilder::class))
];
