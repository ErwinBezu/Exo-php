<?php
namespace App\Repository;

use App\Entity\Client;
use App\Entity\Commande;
use App\Utils\Database;
use \PDO;

class CommandeRepository 
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM commande WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $commande = $stmt->fetch(PDO::FETCH_ASSOC);

        return $commande ?: null;
    }

    public function add(Commande $commande): bool
    {
        $sql ="
            INSERT INTO commande (client_id, date, total) 
            VALUES (:client_id, :date, :total)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':client_id', $commande->client_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $commande->date, PDO::PARAM_STR);
        $stmt->bindValue(':total', $commande->total, PDO::PARAM_STR);

        $insertedRows = $stmt->execute();

        if ($insertedRows > 0) {
            $commande->id = $this->pdo->lastInsertId();

            return true;
        }

        return false;  
    }

    public function update(Commande $commande): bool
    {
        $sql = "
            UPDATE commande
            SET client_id = :client_id, date = :date, total = :total
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':client_id', $commande->client_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $commande->date, PDO::PARAM_STR);
        $stmt->bindValue(':total', $commande->total, PDO::PARAM_STR);
        $stmt->bindValue(':id', $commande->id, PDO::PARAM_INT);

        $updatedRows = $stmt->execute();
        if ($updatedRows > 0) {
            return true;       
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM commande WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $deletedRows = $stmt->execute();
        if ($deletedRows > 0) {
            return true;       
        }
        return false;
    }  
}