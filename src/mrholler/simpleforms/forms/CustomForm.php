<?php

namespace mrholler\simpleforms\forms;

use mrholler\simpleforms\elements\FormElement;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use mrholler\simpleforms\elements\Button;
use mrholler\simpleforms\elements\Dropdown;
use mrholler\simpleforms\elements\Input;
use mrholler\simpleforms\elements\Label;
use mrholler\simpleforms\elements\Slider;
use mrholler\simpleforms\elements\StepSlider;
use mrholler\simpleforms\elements\Toggle;

class CustomForm implements Form
{
    use CallableTrait;

    protected array $elements = [];

    public function __construct(protected $title){}

    public function addElement(FormElement $element): void
    {
        $this->elements[] = $element;
    }

    public function jsonSerialize(): array
    {
        return [
            "type" => "custom_form",
            "title" => $this->title,
            "content" => $this->elements
        ];
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->elements;
    }

    public function getElement(int $index): ?FormElement
    {
        return $this->elements[$index];
    }

    public function setElement(FormElement $element, int $index): void
    {
        if ($element instanceof Button) return;
        $this->elements[$index] = $element;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $this->close($player);
            return;
        } else if (is_array($data)) {
            $return = [];
            foreach ($data as $elementKey => $elementValue) {
                if (isset($this->elements[$elementKey])) {
                    if (($value = $this->elements[$elementKey]->handle($elementValue, $player)) !== null) $return[] = $value;
                } else {
                    throw new FormValidationException("Element with index {$elementKey} does not exist");
                }
            }
        } else {
            throw new FormValidationException("Expected array or null, got " . gettype($data));
        }

        $callable = $this->getCallable();
        if ($callable !== null) {
            $callable($player, $return);
        }
    }

    public function addLabel(string $text): self
    {
        $this->addElement(new Label($text));
        return $this;
    }

    public function addToggle(string $text, bool $value = false): self
    {
        $this->addElement(new Toggle($text, $value));
        return $this;
    }

    public function addDropdown(string $text, array $options = []): self
    {
        $this->addElement(new Dropdown($text, $options));
        return $this;
    }

    public function addInput(string $text, string $placeholder = "", string $defaultText = ""): self
    {
        $this->addElement(new Input($text, $placeholder, $defaultText));
        return $this;
    }

    public function addSlider(string $text, float $min, float $max, float $step = 0.0): self
    {
        $this->addElement(new Slider($text, $min, $max, $step));
        return $this;
    }

    public function addStepSlider(string $text, array $steps = []): self
    {
        $this->addElement(new StepSlider($text, $steps));
        return $this;
    }

}
