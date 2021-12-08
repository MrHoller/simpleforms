<?php

namespace mrholler\simpleforms\elements;

class StepSlider extends FormElement
{

    protected int $defindex = 0;

    public function __construct(protected string $text, protected array $steps = []){}

    public function addStep(string $stepText, $setAsDefault = false): void
    {
        if ($setAsDefault) {
            $this->defindex = count($this->steps);
        }
        $this->steps[] = $stepText;
    }

    public function setStepAsDefault(string $stepText): bool
    {
        $index = array_search($stepText, $this->steps, true);
        if ($index === false) {
            return false;
        }
        $this->defindex = $index;
        return true;
    }

    public function setSteps(array $steps): void
    {
        $this->steps = $steps;
    }

    final public function jsonSerialize(): array
    {
        return [
            "type" => "step_slider",
            "text" => $this->text,
            "steps" => array_map("strval", $this->steps),
            "default" => $this->defindex
        ];
    }

}
