<?php

class SuffixDecorator extends TextDecorator {
    private string $suffix;
    
    public function __construct(Text $text, string $suffix) {
        parent::__construct($text);
        $this->suffix = $suffix;
    }
    
    public function transform(): string {
        return $this->text->transform() . $this->suffix;
    }
}