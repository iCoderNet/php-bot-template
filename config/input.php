<?php

ob_start();
ini_set('display_errors', 1);
error_reporting(1);

$update = json_decode(file_get_contents("php://input"));

if (isset($update->message)) {
    $message = $update->message;
    $message_id = $message->message_id;

    $type = $message->chat->type;
    $chat_id = $message->chat->id;
    $text = $message->text;

    $name = $message->from->first_name;
    $last_name = $message->from->last_name;
    $full_name = $name . ' ' . $last_name;
    $username = $message->from->username;
    $user_id = $message->from->id;
}elseif (isset($update->callback_query)) {
    $call = $update->callback_query;
    $query_id = $call->id;
    $message_id = $call->message->message_id;

    $type = $call->message->chat->type;
    $chat_id = $call->message->chat->id;
    $call_data = $call->data;

    $name = $call->from->first_name;
    $last_name = $call->from->last_name;
    $full_name = $name . ' ' . $last_name;
    $username = $call->from->username;
    $user_id = $call->from->id;
}

?>