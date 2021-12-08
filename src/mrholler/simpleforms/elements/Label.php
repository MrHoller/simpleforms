<?php

namespace mrholler\simpleforms\elements;

class Label extends FormElement
{

    public function __construct(protected string $text){}

    final public function jsonSerialize(): array
    {
        return [
            "type" => "label",
            "text" => $this->text
        ];
    }

}
