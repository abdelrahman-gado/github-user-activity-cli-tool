<?php declare(strict_types=1);

namespace Gado\Guact\Requests;

use Gado\Guact\Abstracts\GithubRequestAbstract;
use GuzzleHttp\Client;

final class GithubActivityRequest extends GithubRequestAbstract
{
    public function __construct(
        private readonly string $username,
        private readonly Client $client = new Client(['base_uri' => self::BASE_URL, 'timeout' => 15]),
    ) {}

    /**
     * @return array<int, mixed>|null
     */
    public function request(int $page = 1): ?array
    {
        try {
            $response = $this->client->request(
                'GET',
                urlencode($this->username) . self::EVENTS_ENDPOINT,
                ['query' => ['per_page' => self::MAX_ITEMS_PER_PAGE, 'page' => $page]],
            );

            if ($response->getStatusCode() === 200) {
                // @phpstan-ignore return.type
                return json_decode($response->getBody()->getContents(), true);
            }

            return null;
        } catch (\Throwable) {
            return null;
        }
    }
}
