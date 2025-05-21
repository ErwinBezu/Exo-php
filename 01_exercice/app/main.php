<?php

require_once __DIR__ . '/Entity/Etudiant.php';
require_once __DIR__ . '/Repository/EtudiantRepository.php';
require_once __DIR__ . '/Utils/Database.php';
require_once __DIR__ . '/functions.php';

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
            voirEtudiants($repo);
            break;

        case 2:
            ajouterEtudiant($repo);
            break;

        case 3:
            modifierEtudiant($repo);
            break;

        case 4:
            supprimerEtudiant($repo);
            break;

        case 5:
            rechercherEtudiant($repo);
            break;

        case 0:
            exit("Au revoir !\n");

        default:
            echo "Option invalide.\n";
            break;
    }
}