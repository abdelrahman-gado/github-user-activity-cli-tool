<?php declare(strict_types=1);

namespace Gado\Guact\Services;

use DateTime;

final readonly class GithubActivityOutputService
{
    /**
     * @param array{ id: string, actor: string, type: string, repo: string, created_at: string }[] $activities
     */
    public static function output(array $activities): void
    {
        foreach ($activities as $activity) {
            self::outputActivity($activity);
        }
    }

    /**
     * @param array{id: string, actor: string, type: string, repo: string, created_at: string} $activity
     */
    private static function outputActivity(array $activity): void
    {
        $createAt = new DateTime($activity['created_at']);
        echo sprintf('ID: %s , ', $activity['id']);
        echo sprintf('Actor: %s , ', $activity['actor']);
        echo sprintf('Type: %s , ', $activity['type']);
        echo sprintf('Repo: %s , ', $activity['repo']);
        echo sprintf('Created At: %s%s', $createAt->format('Y-m-d H:i:s'), PHP_EOL);
    }
}
