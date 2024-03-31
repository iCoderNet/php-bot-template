<?php 

require_once __DIR__ . '/../utils/db/mysql.php';

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);


function step($tg_id, $step=null){
    global $db;
    if ($step!=null) {
        return $db->update('users', ['step' => $step], ['telegram_id' => $tg_id]);
    }else{
        $user = $db->select('users', ['telegram_id' => $tg_id]);
        if (count($user) > 0) {
            return $user[0]['step'];
        }else{
            return null;
        }
    }
}


function stepAdmin($tg_id, $step=null){
    global $db;
    if ($step!=null) {
        return $db->update('users', ['step_admin' => $step], ['telegram_id' => $tg_id]);
    }else{
        $user = $db->select('users', ['telegram_id' => $tg_id]);
        if (count($user) > 0) {
            return $user[0]['step_admin'];
        }else{
            return null;
        }
    }
}

function addUser($tg_id, $full_name, $username=null, $referral_id=0){
    global $db;

    try {
        $referral_id = explode(' ', $referral_id)[1];
        $ref_user = $db->select('users', ['telegram_id'=>$referral_id]);
        if (count($ref_user) == 0) {
            $referral_id = 0;
        }
    } catch (\Throwable $th) {
        $referral_id = 0;
    }

    $user = $db->select('users', ['telegram_id'=>$tg_id]);
    echo json_encode($user, JSON_PRETTY_PRINT);
    if (count($user) == 0) {
        $db->insert('users', [
            'telegram_id' => $tg_id, 
            'full_name' => $full_name, 
            'username' => $username, 
            'referral_id' => $referral_id
        ]);
    }else{
        if ($user['full_name'] != $full_name || $user['username'] != $username) {
            $db->update('users', [
                'full_name' => $full_name,
                'username' => $username
            ], ['telegram_id'=>$tg_id]);
        }
    }
}

?>