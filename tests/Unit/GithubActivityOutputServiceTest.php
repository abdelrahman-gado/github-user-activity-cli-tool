<?php declare(strict_types=1);

namespace Tests\Unit;

use Gado\Guact\Services\GithubActivityOutputService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(GithubActivityOutputService::class)]
final class GithubActivityOutputServiceTest extends TestCase
{
    private GithubActivityOutputService $githubActivityOutputService;

    protected function setUp(): void
    {
        $this->githubActivityOutputService = new GithubActivityOutputService();
    }

    #[Test]
    public function test_output_prints_data(): void
    {
        $data = [
            [
                'id' => '11',
                'actor' => 'test',
                'type' => 'PushEvent',
                'repo' => 'test',
                'created_at' => '2026-07-04T06:33:44Z',
            ],
        ];

        $expectedOutput = 'ID: 11 , Actor: test , Type: PushEvent , Repo: test , Created At: 2026-07-04 06:33:44' . PHP_EOL;
        $this->expectOutputString($expectedOutput);
        $this->githubActivityOutputService->output($data);
    }

    #[Test]
    public function test_output_prints_nothing_if_data_array_empty(): void
    {
        $data = [];
        $expectedOutput = '';
        $this->expectOutputString($expectedOutput);
        $this->githubActivityOutputService->output($data);
    }
}
