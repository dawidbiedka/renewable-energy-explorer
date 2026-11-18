<?php
namespace App\Controllers;

use App\Services\EnergyService;
use App\Core\Response;

class EnergyController
{
    private $service;

    public function __construct()
    {
        $this->service = new EnergyService();
    }

    public function index(): void
    {
        // Pobieramy parametry z adresu URL (np. ?country=POL&year=2023)
        $country = $_GET['country'] ?? null;
        $yearParam = $_GET['year'] ?? null;
        
        // Walidacja roku
        $year = null;
        if ($yearParam !== null) {
            if (!is_numeric($yearParam)) {
                Response::json(['error' => 'Invalid year parameter'], 422);
                return;
            }
            $year = (int) $yearParam;
        }

        $data = $this->service->getEnergyData($country, $year);

        if (empty($data)) {
            Response::json(['error' => 'No data found for the given criteria'], 404);
            return;
        }

        Response::json($data);
    }
}