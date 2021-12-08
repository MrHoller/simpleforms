<?php

namespace mrholler\simpleforms\elements;

class Toggle extends FormElement
{

    public function __construct(protected string $text, protected bool $value = false){}

    public function setDefaultValue(bool $value): void
    {
        $this->value = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            "type" => "toggle",
            "text" => $this->text,
            "default" => $this->value
        ];
    }

}
