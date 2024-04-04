<?php

if(isset($text) && $text){
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>$text,
    ]);
    exit();
}

?>