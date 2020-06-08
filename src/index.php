<?php
class DWgramSync{
    protected $using_curl = true;
    function __construct(){
        include __DIR__."/Classes/load.php";
        if(!function_exists("curl_init")) {
            $this->using_curl = false;
        }
        if(!$this->getStats()->getAPI_online()){
            throw new Exception("DWGram API wrapper: api down");
        }
        var_dump($this->getUsernameChat("shishcatnews"));
    }
    function POST($url,$body) {
        if($this->using_curl) { //use curl if available
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST,true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json')); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_ = json_decode(curl_exec($ch),true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return [$httpcode,$return_];
        } //file get contents fallback
        $options = array('http' => array(
            'method' => 'POST',
            'header'  => "Content-type: application/json",
            'content' => json_encode($body),
            "ignore_errors" => true
        ));
        $context  = stream_context_create($options);
        $res = json_decode(file_get_contents($url, false, $context),true);
        return [explode(" ",$http_response_header[0])[1],$res];
    }
    function getStats(){
        $resp = $this->POST("https://dwgram.xyz/api/stats",[]);
        $this->throwError($resp);
        return new DWgramStats($resp[1]);
    }
    function getUsernameChat($username){
        $resp = $this->POST("https://dwgram.xyz/api/getchat",json_encode(["username"=>$username]));
        var_dump($resp);
        $this->throwError($resp);
        return new DWgramMessages($resp[1]);
    }
    protected function throwError($resp){
        switch($resp[0]){
            case 200:
                break;
            case 503:
            case 502:
            case 521:
                throw new Exception("DWGram API wrapper: 503/502/521 : API down");
                break;
            case 500:
                throw new Exception("DWGram API wrapper: 500 : A generic error happened when processing your request. Please contact @shishcat8214 on telegram for helping us fix this issue.");
                break;
            case 400:
                throw new Exception("DWGram API wrapper: 400 : ".$resp[1]["message"]??"no information.");
                break;
            case 404:
                throw new Exception("DWGram API wrapper: 404 : Not found. Data requested wasnt available for DWGram API to get it.");
                break;
        }
    }
}new DWgramSync();