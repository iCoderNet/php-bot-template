<?php 

function includePhpFiles($folder) {
    $files = glob($folder . '/*.php');

    // Loop through each file and include it
    foreach ($files as $file) {
        if (is_file($file)) {
            require_once $file;
        }
    }
}


?>