<?php

require_once __DIR__ . '/Utils/Database.php';
require_once __DIR__ . '/Entity/Client.php';
require_once __DIR__ . '/Entity/Commande.php';
require_once __DIR__ . '/Repository/ClientRepository.php';
require_once __DIR__ . '/Repository/CommandeRepository.php';
require_once __DIR__ . '/functions.php';

use App\Utils\Database;
use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;

Database::init();

function menu(): void
{
    echo "
    ____                                          _           
    / ___|___  _ __ ___  _ __ ___   __ _ _ __   __| | ___  ___ 
    | |   / _ \| '_ ` _ \| '_ ` _ \ / _` | '_ \ / _` |/ _ \/ __|
    | |__| (_) | | | | | | | | | | | (_| | | | | (_| |  __/\__ \\
    \____\___/|_| |_| |_|_| |_| |_|\__,_|_| |_|\__,_|\___||___/" . PHP_EOL;

    echo "
    1. Afficher les clients
    2. Créer un client
    3. Modifier un client
    4. Supprimer un client
    5. Afficher les détails d'un client
    6. Ajouter une commande
    7. Modifier une commande
    8. Supprimer une commande
    0. Quitter". PHP_EOL;
}

function start(ClientRepository $clientRepo, CommandeRepository $commandeRepo): void
{
    while (true) {
        menu();
        $choice = readline("Choix : ");

        match ($choice) {
            '1' => afficherClients($clientRepo),
            '2' => ajouterClient($clientRepo),
            '3' => modifierClient($clientRepo),
            '4' => supprimerClient($clientRepo),
            '5' => afficherDetailsClient($clientRepo),
            '6' => ajouterCommande($clientRepo, $commandeRepo),
            '7' => modifierCommande($commandeRepo),
            '8' => supprimerCommande($commandeRepo),
            '0' => exit(),
            default => print("saisie invalide"),
        };

        readline("\n---Press enter to continue---\n");
    }
}

$clientRepo = new ClientRepository();
$commandeRepo = new CommandeRepository();

start($clientRepo, $commandeRepo);
