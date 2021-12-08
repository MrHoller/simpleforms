<?php

declare(strict_types=1);

namespace mrholler\simpleforms\elements;

use JsonSerializable;

class ButtonImage implements JsonSerializable
{
    public const IMAGE_TYPE_PATH = "path";
    public const IMAGE_TYPE_URL = "url";

    public function __construct(protected string $data, protected string $type = self::IMAGE_TYPE_URL){}

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return [
            "type" => $this->type,
            "data" => $this->data
        ];
    }
}