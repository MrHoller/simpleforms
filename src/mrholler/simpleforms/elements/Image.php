<?php

namespace mrholler\simpleforms\elements;

class Image extends FormElement
{

    public function __construct(public string $texture, public int $width = 0, public int $height = 0){}

    final public function jsonSerialize(): array
    {
        return [
            "text" => "sign",
            "type" => "image",
            "texture" => $this->texture,
            "size" => [$this->width, $this->height]
        ];
    }

}
