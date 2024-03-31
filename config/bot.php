<?php

function bot($method,$datas=[]){
    $datas["parse_mode"] = "HTML";
    $datas["disable_web_page_preview"] = "true";
        $url = "https://api.telegram.org/bot".API_TOKEN."/".$method;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }else{
            return json_decode($res);
        }
}

?>