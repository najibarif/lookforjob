<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$url = 'https://www.techinasia.com/api/2.0/job-postings?country_name[]=Indonesia&limit=5';

$client = new Client([
    'timeout' => 20,
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Accept' => 'application/json',
    ]
]);

echo "--- Inspecting TechInAsia API ---\n";
try {
    $response = $client->get($url);
    echo "Status: " . $response->getStatusCode() . "\n";
    $json = (string) $response->getBody();
    $data = json_decode($json, true);

    if ($data && isset($data['jobs'])) {
        echo "✅ Found " . count($data['jobs']) . " jobs.\n";
        print_r($data['jobs'][0]);
    } else {
        echo "❌ JSON decoded but no 'jobs' key.\n";
        echo substr($json, 0, 500) . "...\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
