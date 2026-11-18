<?php
namespace App\Services;

use App\Repositories\CountryRepository;

class CountryService
{
    private CountryRepository $repository;

    public function __construct()
    {
        $this->repository = new CountryRepository();
    }

    // Zwraca listę wszystkich krajów
    public function getCountries(): array
    {
        return $this->repository->getAll();
    }

    // Zwraca szczegóły kraju lub null, jeśli nie istnieje
    public function getCountryDetails(int $id): ?array
    {
        return $this->repository->getById($id);
    }
}