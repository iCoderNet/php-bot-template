<?php 
require_once __DIR__ . '/../utils/extra.php';

if($type == 'private') {
    if($text=="🔙 Orqaga"){step($user_id, 'main');stepAdmin($user_id, 'main');}
    require_once __DIR__ . '/users/start.php';
    require_once __DIR__ . '/users/back.php';
    require_once __DIR__ . '/users/admin/index.php';
    require_once __DIR__ . "/users/test.php";
    require_once __DIR__ . "/users/echo.php";
}

?>