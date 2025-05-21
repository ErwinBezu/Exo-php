<?php

namespace App\Entity;

class Client {
    public function __construct(
        public ?int $id, 
        public string $nom, 
        public string $prenom, 
        public string $adresse,
        public string $code_postal,
        public string $ville,
        public string $telephone
    ){}
}
