<?php

require_once __DIR__ . '/Entity/Client.php';
require_once __DIR__ . '/Entity/Commande.php';

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;

function afficherClients(ClientRepository $clientRepo) {
    $clients = $clientRepo->findAll();
    if (empty($clients)) {
        echo "Aucun client trouvé.\n";
    } else {
        foreach ($clients as $c) {
            echo "[{$c->id}] {$c->prenom} {$c->nom} - {$c->adresse} {$c->code_postal} {$c->ville}\n";
        }
    }
}

function ajouterClient(ClientRepository $clientRepo) {
    $nom = readLine("Nom : ");
    $prenom = readLine("Prénom : ");
    $adresse = readLine("Adresse : ");
    $codePostal = readLine("Code Postal : ");
    $ville = readLine("Ville : ");
    $telephone = readLine("Téléphone : ");

    $client = new Client(null, $nom, $prenom, $adresse, $codePostal, $ville, $telephone);

    if ($clientRepo->add($client)) {
        echo "Client créé avec l'id {$client->id}.\n";
    } else {
        echo "Erreur lors de la création du client.\n";
    }
}

function modifierClient(ClientRepository $clientRepo) {
    $id = (int)readline("ID du client à modifier : ");
    $data = $clientRepo->find($id);
    if (!$data) {
        echo "Client introuvable.\n";
        return;
    }
    $clientData = $data['client'];

    $nom = readLine("Nom [{$clientData['nom']}]: ") ?: $clientData['nom'];
    $prenom = readLine("Prénom [{$clientData['prenom']}]: ") ?: $clientData['prenom'];
    $adresse = readLine("Adresse [{$clientData['adresse']}]: ") ?: $clientData['adresse'];
    $codePostal = readLine("Code Postal [{$clientData['code_postal']}]: ") ?: $clientData['code_postal'];
    $ville = readLine("Ville [{$clientData['ville']}]: ") ?: $clientData['ville'];
    $telephone = readLine("Téléphone [{$clientData['telephone']}]: ") ?: $clientData['telephone'];

    $client = new Client($id, $nom, $prenom, $adresse, $codePostal, $ville, $telephone);
    if ($clientRepo->update($client)) {
        echo "Client modifié.\n";
    } else {
        echo "Erreur lors de la modification.\n";
    }
}

function supprimerClient(ClientRepository $clientRepo) {
    $id = (int)readline("ID du client à supprimer : ");
    $clientRepo->delete((int)$id);
}

function afficherDetailsClient(ClientRepository $clientRepo) {
    $id = (int)readLine("ID du client : ");
    $data = $clientRepo->find($id);
    if (!$data) {
        echo "Client introuvable.\n";
        return;
    }

    $c = $data['client'];
    echo "Client : {$c['prenom']} {$c['nom']}\n";
    echo "Adresse : {$c['adresse']}, {$c['code_postal']} {$c['ville']}\n";
    echo "Téléphone : {$c['telephone']}\n";

    if (empty($data['commandes'])) {
    echo "Aucune commande.\n";
    } else {
        echo "Commandes :\n";
        foreach ($data['commandes'] as $cmd) {
            echo "  - #{$cmd['id']} | Date: {$cmd['date']} | Total: {$cmd['total']} €\n";
        }
    }
}

function ajouterCommande(ClientRepository $clientRepo, CommandeRepository $commandeRepo){
    $clientId = (int)readLine("ID du client : ");
    $data = $clientRepo->find($clientId);
    if (!$data) {
        echo "Client introuvable.\n";
        return;
    }
    $date = readLine("Date (YYYY-MM-DD) [aujourd'hui]: ");
    if (empty($date)) {
        $date = date('Y-m-d');
    }
    $total = (float)readLine("Total (€) : ");

    $commande = new Commande(null, $clientId, $date, $total);
    if ($commandeRepo->add($commande)) {
        echo "Commande ajoutée avec l'id {$commande->id}.\n";
    } else {
        echo "Erreur lors de l'ajout de la commande.\n";
    }
}

function modifierCommande(CommandeRepository $commandeRepo) {
    $id = (int)readLine("ID de la commande à modifier : ");
    $commande = $commandeRepo->find($id);
    if (!$commande) {
        echo "Commande introuvable.\n";
        return;
    }

    $date = readLine("Date [{$commande['date']}]: ") ?: $commande['date'];
    $total = readLine("Total [{$commande['total']}]: ") ?: $commande['total'];

    $updatedCommande = new Commande($id, $commande['client_id'], $date, $total);

    if ($commandeRepo->update($updatedCommande)) {
        echo "Commande {$updatedCommande->id} mise à jour.\n";
    } else {
        echo "Erreur lors de la mise à jour.\n";
    }
}

function supprimerCommande(CommandeRepository $commandeRepo) {
    $id = (int)readLine("ID de la commande à supprimer : ");
    if ($commandeRepo->delete($id)) {
        echo "Commande supprimée.\n";
    } else {
        echo "Erreur lors de la suppression.\n";
    }
}