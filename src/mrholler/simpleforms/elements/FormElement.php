<?php

namespace mrholler\simpleforms\elements;

abstract class FormElement implements \JsonSerializable
{

    protected string $text = "";

    public function jsonSerialize(): array
    {
        return [];
    }

    public function getText(): string
    {
        return $this->text;
    }

}
