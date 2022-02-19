<?php
$request = explode('/',$_SERVER['REQUEST_URI']);
$request = end($request);

switch ($request) {
    case 'menu' :
        $foodManager = $container->get('FoodManager');

        $foodController = new \App\Api\Controllers\FoodController($foodManager);
        $foodController->list($request);

        break;

    case 'order' :
        $orderManager = $container->get('OrderManager');
        $foodManager = $container->get('FoodManager');
        $orderController = new \App\Api\Controllers\OrderController($orderManager,$foodManager);
        $user = new \App\Models\User(1,'Yahyya','Taashk');
        $orderController->add($user,1);


}
