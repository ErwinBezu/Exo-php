<?php 

namespace App\Repository;

use App\Entity\Etudiant;
use App\Utils\Database;
use \PDO;

class EtudiantRepository 
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM etudiant";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $etudiants = [];

        foreach ($result as $row) {
            $etudiants[] = new Etudiant(
                (int)$row['id'],
                $row['nom'],
                $row['prenom'],
                $row['date_de_naissance'],
                $row['email']
            );
        }

        return $etudiants;
    }

    public function search(string $term): array
    {
        $sql ="
        SELECT * FROM etudiant 
        WHERE Nom LIKE :term OR Prenom LIKE :term
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['term' => "%$term%"]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $etudiants = [];

        foreach ($result as $row) {
            $etudiants[] = new Etudiant(
                (int)$row['id'],
                $row['nom'],
                $row['prenom'],
                $row['date_de_naissance'],
                $row['email']
            );
        }

        return $etudiants;
    }

    public function add(Etudiant $etudiant): bool
    {
        $sql ="
            INSERT INTO etudiant (nom, prenom, `date_de_naissance`, `email`) 
            VALUES (:nom, :prenom, :date_de_naissance, :email)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nom', $etudiant->nom,PDO::PARAM_STR );
        $stmt->bindValue(':prenom', $etudiant->prenom, PDO::PARAM_STR);
        $stmt->bindValue(':date_de_naissance', $etudiant->date_de_naissance, PDO::PARAM_STR);
        $stmt->bindValue(':email', $etudiant->email, PDO::PARAM_STR);

        $insertedRows = $stmt->execute();

        if ($insertedRows > 0) {
            $etudiant->id = $this->pdo->lastInsertId();

            return true;
        }

        return false;  
    }
    
    public function update(Etudiant $etudiant): bool
    {
        $sql = "
            UPDATE etudiant 
            SET nom = :nom, prenom = :prenom, date_de_naissance = :date_de_naissance, email = :email
            WHERE id = :id
            ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nom', $etudiant->nom,PDO::PARAM_STR );
        $stmt->bindValue(':prenom', $etudiant->prenom, PDO::PARAM_STR);
        $stmt->bindValue(':date_de_naissance', $etudiant->date_de_naissance, PDO::PARAM_STR);
        $stmt->bindValue(':email', $etudiant->email, PDO::PARAM_STR);
        $stmt->bindValue(':id', $etudiant->id, PDO::PARAM_INT);


        $updatedRows = $stmt->execute();
        if ($updatedRows > 0) {
            return true;       
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $sql = "
        DELETE FROM `etudiant` 
        WHERE `id` = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $deletedRows = $stmt->execute();
        if ($deletedRows > 0) {
            return true;       
        }
        return false;
    }
}