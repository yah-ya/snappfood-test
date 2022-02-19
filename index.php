<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require "vendor/autoload.php";


use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/App/dependencies.php');
$container = $containerBuilder->build();

include "App/Api/routes.php";
