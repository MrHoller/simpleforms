<?php

namespace mrholler\simpleforms\forms;

use mrholler\simpleforms\elements\ButtonImage;
use mrholler\simpleforms\elements\Button;
use mrholler\simpleforms\elements\FormElement;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class SimpleForm implements Form
{
    use CallableTrait;

    protected array $buttons = [];

    public function __construct(protected string $title, protected string $content = ""){}

    public function addButton(Button $button): void
    {
        $this->buttons[] = $button;
    }

    public function addButtonEasy(string $text, ?ButtonImage $image = null): void
    {
        $button = new Button($text);
        if ($image !== null)
            $button->addImage($image->getType(), $image->getData());
        $this->buttons[] = $button;
    }

    final public function jsonSerialize(): array
    {
        return [
            "type" => "form",
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => $this->buttons
        ];
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return [$this->content, $this->buttons];
    }

    public function getElement(int $index): ?FormElement
    {
        return $this->buttons[$index];
    }

    public function setElement(FormElement $element, int $index): void
    {
        if (!$element instanceof Button) return;
        $this->buttons[$index] = $element;
    }

    public function handleResponse(Player $player, mixed $data): void
    {
        if ($data === null) {
            $this->close($player);
            return;
        } else if (is_int($data)) {
            $return = "";
            if (isset($this->buttons[$data])) {
                if (($value = $this->buttons[$data]->handle($data, $player)) !== null) $return = $value;
            } else {
                throw new FormValidationException("Option $data does not exist");
            }
        } else {
            throw new FormValidationException("Expected int or null, got " . gettype($data));
        }

        $callable = $this->getCallable();
        if ($callable !== null) {
            $callable($player, $return);
        }
    }
}
