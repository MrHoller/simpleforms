<?php

namespace mrholler\simpleforms\forms;

use pocketmine\form\Form as PMForm;
use pocketmine\player\Player;
use mrholler\simpleforms\elements\FormElement;

interface Form extends PMForm
{

    public function close(Player $player): void;

    public function getTitle(): string;

    public function getContent(): array;

    public function getElement(int $index): ?FormElement;

    public function setElement(FormElement $element, int $index): void;

    public function getCallable(): ?callable;

    public function setCallable(callable $callable): void;
}
