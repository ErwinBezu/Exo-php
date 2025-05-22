<?php

class LowerCaseDecorator extends TextDecorator {
    public function transform(): string {
        return strtolower($this->text->transform());
    }
}