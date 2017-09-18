<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://www.mercadobitcoin.net',
    'timeout'  => 6.0,
]);


// Create a client with a base URI
// $client = new GuzzleHttp\Client(['base_uri' => 'https://foo.com/api/']);
// Send a request to https://foo.com/api/test
$response = $client->request('GET', 'api/BTC/ticker');
var_dump($response->getBody());
// Send a request to https://foo.com/root
// $response = $client->request('GET', '/root');
