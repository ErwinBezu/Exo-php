<?php

namespace App\Utils;

use \PDO;

class Database
{
    private $dbh;
    private static $instance;

    private function __construct()
    {
        $configData = parse_ini_file(__DIR__ . '/../config.ini');
        try {
            $this->dbh = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) 
            );

        } catch (\Exception $exception) {
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage() . '<br>';
            echo '<pre>';
            echo $exception->getTraceAsString();
            echo '</pre>';
            exit;
        }
    }

    public static function init()
    {
        self::getPDO();
        self:: $instance->createTables();
    }

    public static function getPDO()
    {
        if (empty(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$instance->dbh;
    }

    public function createTables()
    {
        $query = "CREATE TABLE IF NOT EXISTS etudiant (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            nom VARCHAR(50) NOT NULL, 
            prenom VARCHAR(50) NOT NULL,
            date_de_naissance DATE NOT NULL, 
            email VARCHAR(100) NOT NULL
        )";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
    }
}