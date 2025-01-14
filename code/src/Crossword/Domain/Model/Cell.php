<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Cell implements JsonSerializable
{
    private null | string $letter;
    private Coordinate $coordinate;

    public function __construct(Coordinate $coordinate, null | string $letter)
    {
        $this->coordinate = $coordinate;
        $this->letter = $letter;
    }

    public function coordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function isLetter(): bool
    {
        return !empty($this->letter);
    }

    public function isBlack(): bool
    {
        return '' === $this->letter;
    }

    public function isEmpty(): bool
    {
        return null === $this->letter;
    }

    public function letter(): ?string
    {
        return $this->letter;
    }

    public function fillLetter(string $letter): void
    {
        $this->letter = $letter;
    }

    public function jsonSerialize(): array
    {
        return [
            'letter' => $this->letter,
            'coordinate' => (string) $this->coordinate,
        ];
    }
}
