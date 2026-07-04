<?php declare(strict_types=1);

namespace Gado\Guact\Services;

use Gado\Guact\Interfaces\TransformerInterface;
use Gado\Guact\Requests\GithubActivityRequest;

final readonly class GithubActivityService
{
    public function __construct(
        private GithubActivityRequest $githubActivityRequest,
        private TransformerInterface $githubActivityTransformer,
    ) {}

    /**
     * @return array{id: string, actor: string, type: string, repo: string, created_at: string}[]
     */
    public function getActivity(int $page = 1): array
    {
        $data = $this->githubActivityRequest->request($page);
        if (!$data) {
            return [];
        }

        return $this->githubActivityTransformer->transform($data);
    }
}
