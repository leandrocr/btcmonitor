<?php

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$Loader = (new josegonzalez\Dotenv\Loader(__DIR__ . '/.env'))
              ->parse()
              ->putenv(true);

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://www.mercadobitcoin.net',
]);

$users = yaml_parse_file(__DIR__ . '/users.yaml');
$users = $users['users'];

while (true) {
    $response = $client->request('GET', 'api/BTC/ticker');
    $response = json_decode($response->getBody());

    function sendAlert($receiptEmail, $alertMessage)
    {
        echo $alertMessage . PHP_EOL;

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_SERVER');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('USERNAME');
        $mail->Password = getenv('PASSWORD');
        $mail->SMTPSecure = 'ssl';
        $mail->Port = getenv('SMTP_PORT');

        $mail->setFrom(getenv('USERNAME'), 'BTC Monitor');
        $mail->addAddress($receiptEmail);

        $mail->isHTML(false);
        $mail->Subject = 'BTC Monitor';
        $mail->Body = $alertMessage;

        $mail->send();
    }

    foreach ($users as $email => $user) {
        $lastPrice = $response->ticker->last;
        echo "Last Price: $lastPrice" . PHP_EOL;
        if ($lastPrice <= $user['low']) {
            sendAlert($email, "LOW: MercadoBitcoin is now at $lastPrice");
            continue;
        }

        if ($lastPrice >= $user['high']) {
            sendAlert($email, "HIGH: MercadoBitcoin is now at $lastPrice");
            continue;
        }
    }

    sleep(getenv('MONITOR_INTERVAL') * 60);
}
