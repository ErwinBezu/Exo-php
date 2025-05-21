<?php

require_once __DIR__ . '/Entity/Etudiant.php';
use App\Entity\Etudiant;

function voirEtudiants($repo) {
    $etudiants = $repo->findAll();
    foreach ($etudiants as $e) {
        echo "$e->id | $e->nom $e->prenom | $e->date_de_naissance | $e->email\n";
    }
}

function ajouterEtudiant($repo) {
    $nom = readline("Nom : ");
    $prenom = readline("Prénom : ");
    $date = readline("Date de naissance (YYYY-MM-DD) : ");
    $email = readline("Email : ");
    $repo->add(new Etudiant(null, $nom, $prenom, $date, $email));
    echo "Étudiant ajouté.\n";
}

function modifierEtudiant($repo) {
    $id = (int)readline("ID de l'étudiant à modifier : ");
    $nom = readline("Nouveau nom : ");
    $prenom = readline("Nouveau prénom : ");
    $date = readline("Nouvelle date de naissance (YYYY-MM-DD) : ");
    $email = readline("Nouvel email : ");
    $repo->update(new Etudiant($nom, $prenom, $date, $email, (int)$id));
    echo "Étudiant modifié.\n";
}

function supprimerEtudiant($repo) {
    $id = (int)readline("ID de l'étudiant à supprimer : ");
    $repo->delete((int)$id);
    echo "Étudiant supprimé.\n";
}

function rechercherEtudiant($repo) {
    $term = readline("Nom ou prénom à rechercher : ");
    $resultats = $repo->search($term);
    foreach ($resultats as $e) {
        echo "$e->id | $e->nom $e->prenom | $e->date_de_naissance | $e->email\n";
    }
}