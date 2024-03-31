<?php
require_once __DIR__ . '/../../keyboard/reply.php';

if($text=="🔙 Orqaga"){
    addUser($chat_id, $full_name, $username, $text);
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>🔽 Quyidagi tugmalardan foydalanishingiz mumkin</b>",
      'reply_markup'=>$main_keyboard,
    ]);
}

?>