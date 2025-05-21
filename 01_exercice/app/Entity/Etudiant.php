<?php

namespace App\Entity;

class Etudiant {
    public function __construct(
        public ?int $id, 
        public string $nom, 
        public string $prenom, 
        public string $date_de_naissance,
        public string $email
    ){}
}
