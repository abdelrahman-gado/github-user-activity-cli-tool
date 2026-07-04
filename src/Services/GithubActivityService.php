<?php declare(strict_types=1);

namespace Gado\Guact\Services;

use Gado\Guact\Abstracts\GithubRequestAbstract;
use Gado\Guact\Interfaces\TransformerInterface;

final readonly class GithubActivityService
{
    public function __construct(
        private GithubRequestAbstract $githubRequestAbstract,
        private TransformerInterface $githubActivityTransformer,
    ) {}

    /**
     * @return array{id: string, actor: string, type: string, repo: string, created_at: string}[]
     */
    public function getActivity(int $page = 1): array
    {
        $data = $this->githubRequestAbstract->request($page);
        if (!$data) {
            return [];
        }

        return $this->githubActivityTransformer->transform($data);
    }
}
