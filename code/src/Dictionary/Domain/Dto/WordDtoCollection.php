<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

use Countable;
use JsonSerializable;

final class WordDtoCollection implements JsonSerializable, Countable
{
    /**
     * @var WordDto[]
     */
    private array $words;

    public function __construct(WordDto ...$words)
    {
        $this->words = $words;
    }

    public function count(): int
    {
        return count($this->words);
    }

    public function jsonSerialize(): array
    {
        return array_map(static fn (WordDto $word) => $word->jsonSerialize(), $this->words);
    }
}
