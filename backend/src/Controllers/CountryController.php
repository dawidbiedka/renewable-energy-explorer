<?php
namespace App\Controllers;

use App\Services\CountryService;
use App\Core\Response;

class CountryController
{
    private CountryService $service;

    public function __construct()
    {
        $this->service = new CountryService();
    }

    // Obsługuje GET /api/v1/countries
    public function index(): void
    {
        $countries = $this->service->getCountries();
        Response::json($countries);
    }

    // Obsługuje GET /api/v1/countries/{id}
    public function show(array $params): void
    {
        $id = (int) $params['id'];
        $country = $this->service->getCountryDetails($id);

        if ($country) {
            Response::json($country);
        } else {
            Response::json(['error' => 'Country not found'], 404);
        }
    }
}