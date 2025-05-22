<?php 
require_once "CatFactory.php"; 
require_once "DogFactory.php"; 

$catFactory = new CatFactory(); 
$cat = $catFactory->createAnimal(); 
$cat->run(); 
$cat->eat();
$cat->sleep(); 


$dogFactory = new DogFactory(); 
$dog = $dogFactory->createAnimal(); 
$dog->run(); 
$dog->eat();
$dog->sleep(); 