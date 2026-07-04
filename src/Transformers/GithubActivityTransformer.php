<?php
declare(strict_types=1);

namespace Gado\Guact\Transformers;

use Gado\Guact\Interfaces\TransformerInterface;

final readonly class GithubActivityTransformer implements TransformerInterface
{
    /**
     * @param array<string, mixed> $data
     * @return array{id: string, actor: string, type: string, repo: string, created_at: string}[]
     */
    public function transform(array $data): array
    {
        $callback = $this->fromEventToActivity(...);
        return array_map($callback, $data); // @phpstan-ignore-line
    }

    /**
     * @param array{id: string, actor: array{display_login: string}, type: string, repo: array{name: string}, created_at: string} $event
     * @return array{id: string, actor: string, type: string, repo: string, created_at: string}
     */
    public function fromEventToActivity(array $event): array
    {
        return [
            'id' => $event['id'],
            'actor' => $event['actor']['display_login'],
            'type' => $event['type'],
            'repo' => $event['repo']['name'],
            'created_at' => $event['created_at'],
        ];
    }
}
