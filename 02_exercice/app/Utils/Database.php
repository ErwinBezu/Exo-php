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
        $query1 = "CREATE TABLE IF NOT EXISTS client (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            nom VARCHAR(50) NOT NULL, 
            prenom VARCHAR(50) NOT NULL,
            adresse VARCHAR(255) NOT NULL, 
            code_postal VARCHAR(10),
            ville VARCHAR(50) NOT NULL, 
            telephone VARCHAR(20)
        )";

        $query2 = "CREATE TABLE IF NOT EXISTS commande (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            client_id INT NOT NULL,
            date DATE NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (client_id) REFERENCES client(id)
        )";

        try {
        $this->dbh->exec($query1);
        $this->dbh->exec($query2);
        echo "Tables créées avec succès.\n";
        } catch (\PDOException $e) {
            echo "Erreur lors de la création des tables : " . $e->getMessage() . "\n";
        }
    }
}