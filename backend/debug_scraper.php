<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$urls = [
    'shopee' => 'https://careers.shopee.co.id/jobs',
    'goto' => 'https://careers.gotocompany.com',
];

$client = new Client([
    'timeout' => 20,
    'verify' => false,
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
    ]
]);

foreach ($urls as $name => $url) {
    echo "--- Inspecting $name ($url) ---\n";
    try {
        $response = $client->get($url);
        $html = (string) $response->getBody();

        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Length: " . strlen($html) . "\n";

        // Check for Next.js data
        if (preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.*?)<\/script>/', $html, $matches)) {
            echo "✅ Found __NEXT_DATA__ (" . strlen($matches[1]) . " bytes)\n";
            file_put_contents("debug_{$name}_next.json", $matches[1]);
        } else {
            echo "❌ No __NEXT_DATA__ found.\n";
        }

    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
