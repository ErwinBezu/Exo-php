<?php

class BrutText implements Text{
    private string $text;
    
    public function __construct(string $text) {
        $this->text = $text;
    }
    
    public function transform(): string {
        return $this->text;
    }
}