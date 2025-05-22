<?php 

abstract class TextDecorator implements Text {
    protected Text $text; 

    public function __construct(Text $text)
    {
        $this->text = $text; 
    }

    public function getDescription(): string{
        return $this->text->getDescription(); 
    }

}