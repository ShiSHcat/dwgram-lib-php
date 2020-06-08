<?php
class DWgramMessages implements JsonSerializable{
    public $messages = [];
    function __construct($messages){
        $this->messages = $messages;
    }

    function getMessageByID($id){
        foreach($this->messages as $k=>$v){
            if($v["id"]==$id) return new DWgramMessage($v);
        }
        return NULL;
    }

    function getAllMessages(){
        $msgs = [];
        foreach($this->messages as $v){
            //var_dump($v);
            $msgs[$v["id"]] = new DWgramMessage($v);
        }
        ksort($msgs);
        return $msgs;
    }

    function jsonSerialize(){
        return $this->messages;
    }
}