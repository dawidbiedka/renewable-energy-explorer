<?php
namespace App\Repositories;

use App\Config\Database;

class IndicatorRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT indicator_id, indicator_code, indicator_name, unit FROM indicators ORDER BY indicator_name ASC";
        return $this->pdo->query($sql)->fetchAll();
    }
}