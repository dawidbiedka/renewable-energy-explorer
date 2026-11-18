<?php
namespace App\Services;

use App\Repositories\EnergyRepository;

class EnergyService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new EnergyRepository();
    }

    public function getEnergyData(?string $country, ?int $year): array
    {
        $rows = $this->repository->getEnergyData($country, $year);

        if (empty($rows)) {
            return [];
        }

        // Formatujemy odpowiedź zgodnie z wymaganiami
        $response = [
            'country' => $rows[0]['country'],
            'iso_code' => $rows[0]['iso_code'],
            'year' => $rows[0]['year'],
            'data' => []
        ];

        foreach ($rows as $row) {
            $response['data'][] = [
                'indicator' => $row['indicator_code'],
                'name' => $row['indicator_name'],
                'value' => (float) $row['value'],
                'unit' => $row['unit']
            ];
        }

        return $response;
    }
}