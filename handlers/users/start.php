<?php
require_once __DIR__ . '/../../keyboard/reply.php';

if($text=="/start" || mb_stripos($text,"/start")!==false){
    addUser($chat_id, $full_name, $username, $text);
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>🍀 Assalomu Alaykum!</b> 
      
<i>✨ Botimizga hush kelibsiz </i>",
      'reply_markup'=>$main_keyboard,
    ]);
    step($user_id, 'main');
    stepAdmin($user_id, 'main');
    exit();
}

?>