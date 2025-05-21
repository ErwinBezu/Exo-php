<?php

namespace App\Entity;

class Commande {
    public function __construct(
        public ?int $id,
        public int $client_id,
        public string $date,
        public float $total
    ) {}
}