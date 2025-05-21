<?php

require_once __DIR__ . '/Entity/Etudiant.php';
require_once __DIR__ . '/Repository/EtudiantRepository.php';
require_once __DIR__ . '/Utils/Database.php';

use App\Repository\EtudiantRepository;
use App\Entity\Etudiant;
use App\Utils\Database;

Database::init();

$repo = new EtudiantRepository();

while (true) {
    echo "\n
1. Voir tous les étudiants
2. Ajouter un étudiant
3. Modifier un étudiant
4. Supprimer un étudiant
5. Rechercher un étudiant
0. Quitter\n";

    $choix = readline("Choisissez une option : ");

    switch ($choix) {
        case 1:
            $etudiants = $repo->findAll();
            foreach ($etudiants as $e) {
                echo "$e->id | $e->nom $e->prenom | $e->date_de_naissance | $e->email\n";
            }
            break;

        case 2:
            $nom = readline("Nom : ");
            $prenom = readline("Prénom : ");
            $date = readline("Date de naissance (YYYY-MM-DD) : ");
            $email = readline("Email : ");
            $repo->add(new Etudiant(null, $nom, $prenom, $date, $email));
            echo "Étudiant ajouté.\n";
            break;

        case 3:
            $id = (int)readline("ID de l'étudiant à modifier : ");
            $nom = readline("Nouveau nom : ");
            $prenom = readline("Nouveau prénom : ");
            $date = readline("Nouvelle date de naissance (YYYY-MM-DD) : ");
            $email = readline("Nouvel email : ");
            $repo->update(new Etudiant($nom, $prenom, $date, $email, (int)$id));
            echo "Étudiant modifié.\n";
            break;

        case 4:
            $id = (int)readline("ID de l'étudiant à supprimer : ");
            $repo->delete((int)$id);
            echo "Étudiant supprimé.\n";
            break;

        case 5:
            $term = readline("Nom ou prénom à rechercher : ");
            $resultats = $repo->search($term);
            foreach ($resultats as $e) {
                echo "$e->id | $e->nom $e->prenom | $e->date_de_naissance | $e->email\n";
            }
            break;

        case 0:
            exit("Au revoir !\n");

        default:
            echo "Option invalide.\n";
            break;
    }
}