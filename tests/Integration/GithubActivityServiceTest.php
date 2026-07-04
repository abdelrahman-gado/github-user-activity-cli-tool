<?php declare(strict_types=1);

namespace Tests\Integration;

use Gado\Guact\Requests\GithubActivityRequest;
use Gado\Guact\Services\GithubActivityService;
use Gado\Guact\Transformers\GithubActivityTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GithubActivityService::class)]
#[UsesClass(GithubActivityRequest::class)]
#[UsesClass(GithubActivityTransformer::class)]
final class GithubActivityServiceTest extends TestCase
{
    #[Test]
    public function test_getActivity_returns_array(): void
    {
        $githubActivityService = new GithubActivityService(
            new GithubActivityRequest('abdelrahman-gado'),
            new GithubActivityTransformer()
        );

        $result = $githubActivityService->getActivity();
        $this->assertNotEmpty($result);
    }


    #[Test]
    public function test_getActivity_returns_empty_array_if_no_data(): void
    {
        $githubActivityService = new GithubActivityService(
            new GithubActivityRequest('abdelrahman-gado'),
            new GithubActivityTransformer()
        );

        $result = $githubActivityService->getActivity(100_000_000);
        $this->assertEmpty($result);
    }

    #[Test]
    public function test_getActivity_returns_empty_array_if_invalid_username(): void
    {
        $githubActivityService = new GithubActivityService(
            new GithubActivityRequest('00invalid-username'),
            new GithubActivityTransformer()
        );

        $result = $githubActivityService->getActivity();
        $this->assertEmpty($result);
    }
}
