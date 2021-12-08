<?php

namespace mrholler\simpleforms\elements;

class Input extends FormElement
{

    public function __construct(protected string $text, public string $placeholder = "", public string $defaultText = ""){}

    final public function jsonSerialize(): array
    {
        return [
            "type" => "input",
            "text" => $this->text,
            "placeholder" => $this->placeholder,
            "default" => $this->defaultText
        ];
    }

}
