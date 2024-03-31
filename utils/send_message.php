<?php

require_once __DIR__ . '/../config/load.php';

if (php_sapi_name() !== 'cli') {
    exit("This script can only be executed from the command line.");
}

if (count($argv) < 3) {
    exit("Usage: php send_message.php <cid> <mid>");
}

$cid = $argv[1];
$mid = $argv[2];


$res = $db->select('users');


if (!$res) {
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"❌ Baza bilan aloqa yo'q",
    ]);
    exit("Failed to fetch chat IDs: ");
}

$sleep_counter = 0;
foreach ($res as $i => $user) {
    $chatId = $user['telegram_id'];

    bot('copymessage', [
        'from_chat_id' => $cid,
        'chat_id' => $chatId,
        'message_id' => $mid,
    ]);

    if(++$sleep_counter > 10){
        sleep(3);
        $sleep_counter = 0;
    }
    sleep(0.5);
}

bot('sendMessage',[
  'chat_id'=>$cid,
  'text'=>"✅ Barchaga xabar yuborildi",
]);

echo "SUCCESS";