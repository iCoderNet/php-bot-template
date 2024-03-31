<?php
require_once __DIR__ . '/buttons.php';
$step = stepAdmin($user_id);

if(($text=="✉️ Xabar yuborish") && in_array($user_id, ADMINS)) {
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>Istalgan turdagi xabaringizni foydalanuvchilarga yuborish mumkin!</b>

<i>BOT foydalanuvchilariga yuboriladigan xabaringizni menga taqdim eting!</i>",
      'reply_markup'=>$back_keyboard,
    ]);
    stepAdmin($user_id, 'send_post_msg');
    exit();
}



if(($step=="send_post_msg") && in_array($user_id, ADMINS)) {
    bot('copymessage',[
        'from_chat_id'=>$chat_id,
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
    ]);
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>Sizning xabaringiz foydalanuvchilarga quyidagi ko'rinishda yetkaziladi</b>
      
Agar maqul bo'lsa <b>✅ Tastiqlash</b> tugmasini bossangiz barchaga xabar yuborish boshlanadi",
      'reply_markup'=>$sendPost_keyboard,
    ]);
    stepAdmin($user_id, 'send_post_confirm|'.$message_id);
    exit();
}


if((stripos($step, 'send_post_confirm|') !== false) && in_array($user_id, ADMINS)) {
    if ($text == "✅ Tastiqlash") {
        $mid = explode('|', $step)[1];
        $folder = __DIR__ . '/../../../utils/send_message.php';
        $command = "php {$folder} {$chat_id} {$mid} > /dev/null 2>&1 &";
        exec($command);
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=> "<b>✉️ Xabar yuborish boshlandi...</b> ",
            'reply_markup'=>$panel_keyboard,
        ]);
    }else{
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>❌ Xabarni foydalanuvchilarga yuborish bekor qilindi</b>",
            'reply_markup'=>$back_keyboard,
          ]);
    }
    stepAdmin($user_id, 'main');
    exit();
}