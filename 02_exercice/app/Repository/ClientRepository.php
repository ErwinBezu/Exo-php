<?php 

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Commande;
use App\Utils\Database;
use \PDO;

class ClientRepository 
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM client";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clients = [];

        foreach ($result as $row) {
            $clients[] = new Client(
                (int)$row['id'],
                $row['nom'],
                $row['prenom'],
                $row['adresse'],
                $row['code_postal'],
                $row['ville'],
                $row['telephone']
            );
        }

        return $clients;
    }

    public function find(int $id): ?array
	{
        $sql = "SELECT * FROM client WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute(['id' => $id]);
        $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$clientData) {
            return null;
        }

        $sql2 = "SELECT * FROM commande WHERE client_id = :id";
        $stmt = $this->pdo->prepare($sql2);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'client' => $clientData,
            'commandes' => $commandes
        ];
	}


    public function add(Client $client): bool
    {
        $sql ="
            INSERT INTO client (nom, prenom, adresse, code_postal, ville, telephone) 
            VALUES (:nom, :prenom, :adresse, :code_postal, :ville, :telephone)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nom', $client->nom,PDO::PARAM_STR );
        $stmt->bindValue(':prenom', $client->prenom, PDO::PARAM_STR);
        $stmt->bindValue(':adresse', $client->adresse, PDO::PARAM_STR);
        $stmt->bindValue(':code_postal', $client->code_postal, PDO::PARAM_STR);
        $stmt->bindValue(':ville', $client->ville, PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $client->telephone, PDO::PARAM_STR);

        $insertedRows = $stmt->execute();

        if ($insertedRows > 0) {
            $client->id = $this->pdo->lastInsertId();

            return true;
        }

        return false;  
    }
    
    public function update(Client $client): bool
    {
        $sql = "
            UPDATE client 
            SET nom = :nom, prenom = :prenom, adresse = :adresse, code_postal = :code_postal, ville = :ville, telephone = :telephone
            WHERE id = :id
            ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nom', $client->nom,PDO::PARAM_STR );
        $stmt->bindValue(':prenom', $client->prenom, PDO::PARAM_STR);
        $stmt->bindValue(':adresse', $client->adresse, PDO::PARAM_STR);
        $stmt->bindValue(':code_postal', $client->code_postal, PDO::PARAM_STR);
        $stmt->bindValue(':ville', $client->ville, PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $client->telephone, PDO::PARAM_STR);
        $stmt->bindValue(':id', $client->id, PDO::PARAM_INT);

        $updatedRows = $stmt->execute();
        if ($updatedRows > 0) {
            return true;       
        }
        return false;
    }

    public function delete(int $id): bool
    {
        try {
            $this->pdo->beginTransaction();

            $sql1 = "DELETE FROM commande WHERE client_id = :id";
            $stmt1 = $this->pdo->prepare($sql1);
            $stmt1->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt1->execute();

            $sql2 = "DELETE FROM client WHERE id = :id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt2->execute();

            $this->pdo->commit();
            echo "La transaction s'est bien réalisé!\n";
            return true;

        } catch (\PDOException $e) {
            echo "Erreur, nous mettons fin à la transation : ", $e->getMessage() . "\n";
            $this->pdo->rollBack();
            return false;
        }
    }
}