<?php declare(strict_types=1);

namespace Tests\Unit;

use Gado\Guact\Abstracts\GithubRequestAbstract;
use Gado\Guact\Requests\GithubActivityRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GithubActivityRequest::class)]
#[UsesClass(GithubRequestAbstract::class)]
final class GithubActivityRequestTest extends TestCase
{
    #[Test]
    public function test_request_should_return_null_when_request_fails(): void
    {
        $username = 'test';
        $mockHandler = new MockHandler([
            new RequestException(
                'error 5xx',
                new Request('GET', $username . GithubRequestAbstract::EVENTS_ENDPOINT),
            ),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client([
            'base_uri' => GithubRequestAbstract::BASE_URL,
            'timeout' => 15,
            'handler' => $handlerStack,
        ]);

        $githubActivityRequest = new GithubActivityRequest($username, $client);
        $result = $githubActivityRequest->request();
        $this->assertNull($result);
    }

    #[Test]
    public function test_request_should_return_array_when_request_succeeds(): void
    {
        $username = 'test';
        $expectedData = [
            [
                'id' => '123',
                'actor' => ['display_login' => 'user1'],
                'type' => 'PushEvent',
                'repo' => ['name' => 'repo1'],
                'created_at' => '2023-01-01T00:00:00Z',
            ],
        ];

        $json = json_encode($expectedData);
        $mockHandler = new MockHandler([
            new Response(
                status: 200,
                headers: ['Content-Type' => 'application/json'],
                body: $json ?: null
            ),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client([
            'base_uri' => GithubRequestAbstract::BASE_URL,
            'timeout' => 15,
            'handler' => $handlerStack,
        ]);

        $githubActivityRequest = new GithubActivityRequest($username, $client);
        $result = $githubActivityRequest->request();
        $this->assertIsArray($result);
        $this->assertSame($expectedData, $result);
    }

    #[Test]
    public function test_request_should_return_null_when_request_give_4xx(): void
    {
        $username = 'test';
        $mockHandler = new MockHandler([
            new Response(
                status: 304,
                headers: ['Content-Type' => 'application/json']
            ),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client([
            'base_uri' => GithubRequestAbstract::BASE_URL,
            'timeout' => 15,
            'handler' => $handlerStack,
        ]);

        $githubActivityRequest = new GithubActivityRequest($username, $client);
        $result = $githubActivityRequest->request();
        $this->assertNull($result);
    }

    #[Test]
    public function test_request_should_return_empty_array_when_requested_page_is_too_high(): void
    {
        $page = 10000; // Github activity events endpoint return only last 90 days events
        $username = 'test';
        $expectedData = [];
        $json = json_encode($expectedData);
        $mockHandler = new MockHandler([
            new Response(
                status: 200,
                headers: ['Content-Type' => 'application/json'],
                body: $json ?: null
            ),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client([
            'base_uri' => GithubRequestAbstract::BASE_URL,
            'timeout' => 15,
            'handler' => $handlerStack,
        ]);

        $githubActivityRequest = new GithubActivityRequest($username, $client);
        $result = $githubActivityRequest->request($page);
        $this->assertIsArray($result);
        $this->assertSame($expectedData, $result);
    }
}
