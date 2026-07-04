<?php declare(strict_types=1);

namespace Tests\Unit;

use Gado\Guact\Interfaces\TransformerInterface;
use Gado\Guact\Transformers\GithubActivityTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(GithubActivityTransformer::class)]
final class GithubActivityTransformerTest extends TestCase
{
    private TransformerInterface $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new GithubActivityTransformer();
    }

    #[Test]
    public function test_transform_should_return_empty_array_when_given_empty_array(): void
    {
        $data = [];
        $result = $this->transformer->transform($data);
        $this->assertSame([], $result);
    }

    #[Test]
    public function test_transform_should_return_transformed_array_when_given_non_empty_array(): void
    {
        $data = [
            [
                'id' => '123',
                'actor' => ['display_login' => 'user1'],
                'type' => 'PushEvent',
                'repo' => ['name' => 'repo1'],
                'created_at' => '2023-01-01T00:00:00Z',
            ],
            [
                'id' => '456',
                'actor' => ['display_login' => 'user2'],
                'type' => 'PullRequestEvent',
                'repo' => ['name' => 'repo2'],
                'created_at' => '2023-01-02T00:00:00Z',
            ],
        ];

        $expected = [
            [
                'id' => '123',
                'actor' => 'user1',
                'type' => 'PushEvent',
                'repo' => 'repo1',
                'created_at' => '2023-01-01T00:00:00Z',
            ],
            [
                'id' => '456',
                'actor' => 'user2',
                'type' => 'PullRequestEvent',
                'repo' => 'repo2',
                'created_at' => '2023-01-02T00:00:00Z',
            ],
        ];
        $result = $this->transformer->transform($data);
        $this->assertSame($expected, $result);
    }
}
