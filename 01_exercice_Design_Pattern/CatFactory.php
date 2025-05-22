<?php 

require_once "AnimalFactory.php"; 
require_once "Animal.php"; 
require_once "Cat.php"; 

class CatFactory extends AnimalFactory{
    public function createAnimal(): Animal{
        return new Cat(); 
    }
}