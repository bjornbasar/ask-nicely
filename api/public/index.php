<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Model/Employee.php';
require_once __DIR__ . '/../src/Controller/EmployeeController.php';
require_once __DIR__ . '/../src/Router.php';

$router = new Router();
$router->handleRequest();
