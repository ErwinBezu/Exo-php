<?php 

require_once "Animal.php"; 

class Dog implements Animal{
    public function eat(){
        echo "Miam miam je mange de la viande \n"; 
    }

    public function run(){
        echo "Je pourchasse le facteur\n"; 
    }

    public function sleep(){
        echo "J'ai des gaz en dormant\n"; 
    }
}