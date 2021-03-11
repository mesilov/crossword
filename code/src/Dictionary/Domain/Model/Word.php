<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Model;

use JsonSerializable;

final class Word implements JsonSerializable
{
    private string $language;
    private string $word;
    private string $definition;

    public function __construct(string $language, string $word, string $definition)
    {
        $this->language = $language;
        $this->word = $word;
        $this->definition = $definition;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function word(): string
    {
        return $this->word;
    }

    public function definition(): string
    {
        return $this->definition;
    }

    public function length(): int
    {
        return strlen($this->word);
    }


    public function isEmpty(): bool
    {
        return 0 === $this->length();
    }

    public function jsonSerialize(): array
    {
        return [
            'language' => $this->language,
            'word' => $this->word,
            'definition' => $this->definition,
            'length' => $this->length(),
        ];
    }
}
