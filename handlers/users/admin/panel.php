<?php
require_once __DIR__ . '/buttons.php';

if(($text=="/panel" || $text=="/admin") && in_array($user_id, ADMINS)) {
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>👮‍♂️ Admin panelga o'tish amalga oshirildi!</b> 

<i>⬇️ Quyidagi tugmalardan foydalanishingiz mumkin</i>",
      'reply_markup'=>$panel_keyboard,
    ]);
    step($user_id, 'main');
    stepAdmin($user_id, 'main');
    exit();
}

if(($text=="⬅️ Ortga") && in_array($user_id, ADMINS)) {
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>⬇️ Quyidagi tugmalardan foydalanishingiz mumkin</b>",
      'reply_markup'=>$panel_keyboard,
    ]);
    step($user_id, 'main');
    stepAdmin($user_id, 'main');
    exit();
}

?>