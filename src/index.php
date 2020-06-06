<?php
class DWgramGetChatSync{
    function __construct(){
        if (!function_exists("curl_init")) {
            die("DWGram API wrapper error: CURL PHP bindings are needed. The async version requires insted amphp/http-client.");
        }
        include __DIR__."/Classes/load.php";
        var_dump($this->makerequest()[1]);
    }
    function makerequest() {
        $ch = curl_init();
        $url = "https://dwgram.xyz/api/getchat?bypass_cache=true&joinchat=@loll213";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return_ = json_decode(curl_exec($ch),true);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$httpcode,$return_];
    }
}
new DWgramGetChatSync();