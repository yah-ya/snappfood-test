<?php
namespace App\Lib\Services;
use App\Lib\Interfaces\DBInterface;

class SQLite implements DBInterface {

    const PATH_TO_SQLITE_FILE = 'sqlite.db';
    private $pdo = null;

    public function connect(): \PDO
    {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . self::PATH_TO_SQLITE_FILE);
        }
        return $this->pdo;
    }

    public function query(string $query)
    {
        $this->pdo->exec($query);
    }

    public function fetchData(string $query):array
    {
        $stmt = $this->pdo->query($query);
        $res = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        return $res;
    }

    public function getTables(): array
    {
        $stmt = $this->pdo->query("SELECT name
                                   FROM sqlite_master
                                   WHERE type = 'table'
                                   ORDER BY name");
        $tables = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tables[] = $row['name'];
        }
        return $tables;
    }
}
