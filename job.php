<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require "vendor/autoload.php";



use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/App/dependencies.php');
$container = $containerBuilder->build();

$foodManager = $container->get('FoodManager');

set_time_limit(0);
while (true) {
    $foodManager->increaseIngredients(4);
    sleep(900);//15 minutes
}

