<?php declare(strict_types=1);

namespace Gado\Guact\Requests;

use Gado\Guact\Abstracts\GithubRequestAbstract;
use GuzzleHttp\Client;

final readonly class GithubActivityRequest extends GithubRequestAbstract
{
    public function __construct(
        private string $username,
    ) {}

    /**
     * @return array<string, mixed>|null
     */
    public function request(int $page = 1): ?array
    {
        $client = new Client(['base_uri' => self::BASE_URL, 'timeout' => 15]);

        try {
            $response = $client->request(
                'GET',
                $this->username . self::EVENTS_ENDPOINT,
                ['query' => ['per_page' => self::MAX_ITEMS_PER_PAGE, 'page' => $page]],
            );

            if ($response->getStatusCode() === 200) {
                $resultItems =  json_decode($response->getBody()->getContents(), true);
                if (!is_array($resultItems)) {
                    return null;
                }
                
                // @phpstan-ignore return.type
                return $resultItems;
            }

            return null;
        } catch (\Throwable) {
            return null;
        }
    }
}
