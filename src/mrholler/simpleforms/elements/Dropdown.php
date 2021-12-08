<?php

namespace mrholler\simpleforms\elements;

class Dropdown extends FormElement
{

    protected int $defindex = 0;

    public function __construct(protected string $text, protected array $options = []){}

    public function addOption(string $optionText, bool $isDefault = false): void
    {
        if ($isDefault) {
            $this->defindex = count($this->options);
        }
        $this->options[] = $optionText;
    }

    public function setOptionAsDefault(string $optionText): bool
    {
        $index = array_search($optionText, $this->options, true);
        if ($index === false) {
            return false;
        }
        $this->defindex = $index;
        return true;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    final public function jsonSerialize(): array
    {
        return [
            "type" => "dropdown",
            "text" => $this->text,
            "options" => $this->options,
            "default" => $this->defindex
        ];
    }

}