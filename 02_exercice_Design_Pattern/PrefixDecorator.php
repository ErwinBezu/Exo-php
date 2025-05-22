<?php

class PrefixDecorator extends TextDecorator {
    private string $prefix;
    
    public function __construct(Text $text, string $prefix) {
        parent::__construct($text);
        $this->prefix = $prefix;
    }
    
    public function transform(): string {
        return $this->prefix . $this->text->transform();
    }
}
