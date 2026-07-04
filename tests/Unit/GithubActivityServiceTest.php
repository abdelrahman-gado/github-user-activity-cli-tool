<?php declare(strict_types=1);

namespace Tests\Unit;

use Gado\Guact\Abstracts\GithubRequestAbstract;
use Gado\Guact\Interfaces\TransformerInterface;
use Gado\Guact\Services\GithubActivityService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GithubActivityService::class)]
#[UsesClass(GithubRequestAbstract::class)]
#[UsesClass(TransformerInterface::class)]
final class GithubActivityServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private GithubRequestAbstract&MockInterface $githubRequestMock;

    private TransformerInterface&MockInterface $transformerMock;

    protected function setUp(): void
    {
        $this->githubRequestMock = Mockery::mock(GithubRequestAbstract::class);
        $this->transformerMock = Mockery::mock(TransformerInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    #[Test]
    public function test_getActivity_method_return_array(): void
    {
        $this->githubRequestMock->expects('request')
            ->once()
            ->andReturn([
                [
                    'id' => '111',
                    'actor' => ['display_login' => 'test'],
                    'type' => 'PullEvent',
                    'repo' => ['name' => 'testRepo'],
                    'created_at' => '2026-07-04T06:33:44Z',
                ],
            ]);

        $expectedData = [
            [
                'id' => '111',
                'actor' => 'test',
                'type' => 'PullEvent',
                'repo' => 'testRepo',
                'created_at' => '2026-07-04T06:33:44Z',
            ],
        ];

        $this->transformerMock->expects('transform')
            ->once()
            ->andReturn($expectedData);

        $githubActivityService = new GithubActivityService(
            $this->githubRequestMock,
            $this->transformerMock
        );

        $this->assertSame($expectedData, $githubActivityService->getActivity());
    }
}
