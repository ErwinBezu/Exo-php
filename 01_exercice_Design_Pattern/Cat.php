<?php 

require_once "Animal.php"; 

class Cat implements Animal{
    public function eat(){
        echo "Miam miam je mange du thon \n"; 
    }

    public function run(){
        echo "Je cours après la balle\n"; 
    }

    public function sleep(){
        echo "Je ronfle 20h par jour\n"; 
    }
}