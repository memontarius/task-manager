<?php

namespace Database\Factories;

trait PresetValuesTrait
{
    private int $callCount = 0;

    private abstract function getValues(): array;

    private abstract function getAlternativeValue(): mixed;

    private function getNextValue()
    {
        $value = $this->callCount < count($this->getValues())
            ? $this->getValues()[$this->callCount]
            : $this->getAlternativeValue();

        $this->callCount++;

        return $value;
    }
}
