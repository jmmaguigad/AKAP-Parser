<?php

namespace AkapCsvProcessor;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function insertData(array $row, $originalId)
    {
        try {
            $this->pdo->beginTransaction(); // Start transaction
            $uniqueKey = Deduplicate::generateUniqueKey($row);

            $birthYear = null;
            $birthMonth = null;
            $birthDay = null;
            $birthdate = null;

            if ($row['birthdate'] instanceof \DateTime) { // Check if it's a DateTime object
                $birthYear = $row['birthdate']->format('Y');
                $birthMonth = $row['birthdate']->format('m');
                $birthDay = $row['birthdate']->format('d');
                $birthdate = $row['birthdate']; //->format('Y-m-d')
            }

            $stmt = $this->pdo->prepare("INSERT IGNORE INTO processed_data (original_id, firstname, middlename, lastname, extensionname, birthdate, birth_year, birth_month, birth_day, sex, province, unique_key) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$originalId, $row['firstname'], $row['middlename'], $row['lastname'], $row['extensionname'], $birthdate, $birthYear, $birthMonth, $birthDay, $row['sex'], $row['province'], $uniqueKey]);

            $this->pdo->commit(); // Commit transaction
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Rollback on error
            die("Database error: " . $e->getMessage());
        }
    }
}
