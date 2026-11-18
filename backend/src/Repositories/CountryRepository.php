<?php
namespace App\Repositories;

use App\Config\Database;
use PDO;

class CountryRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Pobiera wszystkie kraje (dla /api/v1/countries)
    public function getAll(): array
    {
        $sql = "SELECT country_id, name, iso_code FROM countries ORDER BY name ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    // Pobiera szczegóły jednego kraju (dla /api/v1/countries/{id})
    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT country_id, name, iso_code FROM countries WHERE country_id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        
        return $result ? $result : null;
    }
}