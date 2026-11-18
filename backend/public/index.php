<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use App\Core\Router;
use App\Controllers\CountryController;
use App\Controllers\IndicatorController;
use App\Controllers\EnergyController;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$router = new Router();

// 1. Lista krajów
$router->add('GET', '/api/v1/countries', function () {
    (new CountryController())->index();
});

// 2. Szczegóły kraju
$router->add('GET', '/api/v1/countries/{id}', function ($params) {
    (new CountryController())->show($params);
});

// 3. Lista wskaźników
$router->add('GET', '/api/v1/indicators', function () {
    (new IndicatorController())->index();
});

// 4. Dane energetyczne
$router->add('GET', '/api/v1/energy', function () {
    (new EnergyController())->index();
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);
?>