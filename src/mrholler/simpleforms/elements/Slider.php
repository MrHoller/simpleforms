<?php

namespace mrholler\simpleforms\elements;

use InvalidArgumentException;

class Slider extends FormElement
{

    protected float $defvalue = 0.0;

    public function __construct(protected string $text, protected float $min, protected float $max, protected float $step = 0.0)
    {
        if ($min > $max) {
            $this->min = min($this->min, $this->max);
            $this->max = max($this->min, $this->max);
        }
        $this->defvalue = $this->min;
        $this->setStep($step);
    }

    public function setStep(float $step): void
    {
        if ($step < 0) {
            throw new InvalidArgumentException(__METHOD__ . " Step should be positive");
        }
        $this->step = $step;
    }

    public function setDefaultValue(float $value): void
    {
        if ($value < $this->min || $value > $this->max) {
            throw new InvalidArgumentException(__METHOD__ . " Default value out of borders");
        }
        $this->defvalue = $value;
    }

    final public function jsonSerialize(): array
    {
        $data = [
            "type" => "slider",
            "text" => $this->text,
            "min" => $this->min,
            "max" => $this->max
        ];
        if ($this->step > 0) {
            $data["step"] = $this->step;
        }
        if ($this->defvalue !== $this->min) {
            $data["default"] = $this->defvalue;
        }
        return $data;
    }

}
