<?php declare(strict_types=1);

namespace Gado\Guact\Abstracts;

abstract class GithubRequestAbstract
{
    public const string BASE_URL = 'https://api.github.com/users/';

    public const string EVENTS_ENDPOINT = '/events';

    public const int MAX_ITEMS_PER_PAGE = 30;

    /**
     * @return array<int, mixed>|null
     */
    abstract public function request(int $page = 1): ?array;
}
