<?php 

class UpperCaseDecorator extends TextDecorator {
    public function transform(): string {
        return strtoupper($this->text->transform());
    }
}
