<?php
namespace App\Services;

use App\Repositories\IndicatorRepository;

class IndicatorService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new IndicatorRepository();
    }

    public function getIndicators(): array
    {
        return $this->repository->getAll();
    }
}