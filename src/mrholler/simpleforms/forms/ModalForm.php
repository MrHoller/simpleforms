<?php

namespace mrholler\simpleforms\forms;

use mrholler\simpleforms\elements\FormElement;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class ModalForm implements Form
{
    use CallableTrait;

    public function __construct(protected string $title, protected string $content, protected string $yesButtonText = "Да", protected string $noButtonText = "Нет"){}

    final public function jsonSerialize(): array
    {
        return [
            "type" => "modal",
            "title" => $this->title,
            "content" => $this->content,
            "button1" => $this->yesButtonText,
            "button2" => $this->noButtonText,
        ];
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return [$this->content, $this->yesButtonText, $this->noButtonText];
    }

    public function handleResponse(Player $player, $data): void
    {
        if (!is_bool($data)) {
            throw new FormValidationException("Expected bool, got " . gettype($data));
        }
        $callable = $this->getCallable();
        if ($callable !== null) {
            $callable($player, (bool)$data);
        }
    }

    public function getElement(int $index): ?FormElement
    {
        return null;
    }

    public function setElement(FormElement $element, int $index): void{}
}
