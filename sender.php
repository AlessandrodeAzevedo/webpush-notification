<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "./vendor/autoload.php";

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
$endpoint = 'https://fcm.googleapis.com/fcm/send/ds_FwqIkw3E:APA91bHtofdl5aTHFv_srsxmvQmwZT-BaP4PhIMBYj4sXyQQvkUqp2_4aexE-TQzCDF4hftAuApbgNThsGvbIY8cFQFzuk3-KbscZXIv7FirKmneVdhBqfM8nddimTAb5Njx7NZ5pSiA';

$auth = [
    'VAPID' => [
        'subject' => 'mailto: <alessandrodeazevedo@gmail.com>', 
        'publicKey' => 'BJUfJsU7EDmjXHpYV30pZJaA0WPFjWCKRTfmKAYesAaEwczoeNynzHanouDqmd-_kiLLtaCwu3JpyYXSJa26ga0',
        'privateKey' => '64ZeS8UUxDHomD8AOOKyAiDxtt6mZGXynNKI5Rj47Ng',
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




























