<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "./vendor/autoload.php";

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
$endpoint = '';

$auth = [
    'VAPID' => [
        'subject' => '', 
        'publicKey' => '',
        'privateKey' => '',
    ],
];
$notification['payload'] = '{msg:"test"}';
$webPush = new WebPush($auth);
$webPush->queueNotification(
    new Subscription($endpoint,null,null,'aesgcm'),
    $notification['payload']
);
foreach ($webPush->flush() as $report) {
    $endpoint = $report->getRequest()->getUri()->__toString();
    if ($report->isSuccess()) {
        echo "[v] Message sent successfully for subscription {$endpoint}.";
    } else {
        echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
    }
}
