<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Dto;

final class StorageWordCollection
{
    /**
     * @var StorageWord[]
     */
    private array $words;

    public function __construct(array $words)
    {
        $this->words = array_map(fn (array $attributes) => new StorageWord($attributes), $words);
    }

    public function words(): array
    {
        return $this->words;
    }
}