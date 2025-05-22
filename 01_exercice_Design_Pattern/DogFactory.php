<?php 

require_once "AnimalFactory.php"; 
require_once "Animal.php"; 
require_once "Dog.php"; 

class DogFactory extends AnimalFactory{
    public function createAnimal(): Animal{
        return new Dog(); 
    }
}