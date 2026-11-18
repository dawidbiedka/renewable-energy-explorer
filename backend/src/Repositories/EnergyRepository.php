<?php
namespace App\Repositories;

use App\Config\Database;

class EnergyRepository
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }
    public function getEnergyData(?string $countryIso, ?int $year): array
    {
        $sql = "SELECT 
                    c.name AS country, 
                    c.iso_code, 
                    i.indicator_code, 
                    i.indicator_name, 
                    i.unit, 
                    e.year, 
                    e.value
                FROM energy_observations e
                JOIN countries c ON e.country_id = c.country_id
                JOIN indicators i ON e.indicator_id = i.indicator_id
                WHERE 1=1";
        $params = [];
        if ($countryIso) {
            $sql .= " AND c.iso_code = :country";
            $params[':country'] = strtoupper($countryIso);
        }
        
        if ($year) {
            $sql .= " AND e.year = :year";
            $params[':year'] = $year;
        }
        $sql .= " ORDER BY i.indicator_name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}