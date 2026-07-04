<?php declare(strict_types=1);

namespace Gado\Guact\Interfaces;

interface TransformerInterface
{
    /**
     * @param array<int, mixed> $data
     * @return array{id: string, actor: string, type: string, repo: string, created_at: string}[]
     */
    public function transform(array $data): array;
}
