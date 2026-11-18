<?php
namespace App\Controllers;

use App\Services\IndicatorService;
use App\Core\Response;

class IndicatorController
{
    private IndicatorService $service;

    public function __construct()
    {
        $this->service = new IndicatorService();
    }

    public function index(): void
    {
        Response::json($this->service->getIndicators());
    }
}