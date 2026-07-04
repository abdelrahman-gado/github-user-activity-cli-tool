<?php declare(strict_types=1);

namespace Gado\Guact;

require_once __DIR__ . "/../vendor/autoload.php";
use Gado\Guact\Requests\GithubActivityRequest;
use Gado\Guact\Services\GithubActivityOutputService;
use Gado\Guact\Services\GithubActivityService;
use Gado\Guact\Transformers\GithubActivityTransformer;

$username = $argv[1] ?? null;
if (!$username) {
    echo "Usage: php github-activity.php <github-username>\n";
    exit(1);
}

if ($username === '-h' || $username === '--help') {
    echo "Usage: php github-activity.php <github-username>\n";
    echo "Fetches and displays the GitHub activity for the specified username.\n";
    exit(0);
}

$page = 1;
$githubActivityService = new GithubActivityService(
    new GithubActivityRequest($username),
    new GithubActivityTransformer(),
);

$data = $githubActivityService->getActivity($page);
if ($data === []) {
    echo sprintf('No data available for user: %s%s', $username, PHP_EOL);
    exit(1);
}

GithubActivityOutputService::output($data);

while ($data) {
    $enter = readline('press enter for more:');
    $data = $githubActivityService->getActivity(++$page);
    if ($data === []) {
        echo sprintf('No data available for user: %s%s', $username, PHP_EOL);
        exit(1);
    }

    GithubActivityOutputService::output($data);
}
