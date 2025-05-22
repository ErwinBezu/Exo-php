<?php

require_once "Text.php"; 
require_once "BrutText.php"; 
require_once "TextDecorator.php"; 
require_once "UpperCaseDecorator.php";
require_once "LowerCaseDecorator.php"; 
require_once "PrefixDecorator.php";
require_once "SuffixDecorator.php";

$text = new BrutText("Bonjour les gens");
$text = new UpperCaseDecorator($text);
$text = new PrefixDecorator($text, ">>> ");
$text = new SuffixDecorator($text, " <<<");
echo $text->transform(), PHP_EOL; 

$text = new BrutText("BONJOUR");
$text = new LowerCaseDecorator($text);
$text = new PrefixDecorator($text, "+++ ");
$text = new SuffixDecorator($text, " +++");
echo $text->transform(), PHP_EOL; 