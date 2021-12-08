<?php

namespace mrholler\simpleforms\elements;

use InvalidArgumentException;

class Button extends FormElement
{
    public const TYPE_PATH = "path";
    public const TYPE_URL = "url";

    protected string $image;

    public function __construct(protected string $text){}

    public function addImage(string $imageType, string $imagePath): void
    {
        if ($imageType !== self::TYPE_PATH && $imageType !== self::TYPE_URL) {
            throw new InvalidArgumentException("Invalid type image");
        }
        $this->image = new ButtonImage($imagePath, $imageType);
    }

    final public function jsonSerialize(): array
    {
        $data = [
            "type" => "button",
            "text" => $this->text
        ];
        if ($this->image !== null) {
            $data["image"] = $this->image;
        }
        return $data;
    }

}
