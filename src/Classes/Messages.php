<?php
class DWgramMessages implements JsonSerializable{
    public $messages = [];
    function __construct($messages){
        $this->messages = $messages;
    }
    function getRawMessages(){
        return $this->messages;
    }
    function getRawMessagesAssoc(){
        $msgs = [];
        foreach($this->messages as $k=>$v){
            $msgs[$v["id"]] = $v;
        }
        return $msgs;
    }
    function getMessageByID($id){
        foreach($this->messages as $k=>$v){
            if($v["id"]==$id) return new DWgramMessage($v);
        }
        return NULL;
    }
    function getAllMessagesAssoc($id){
        $msgs = [];
        foreach($this->messages as $k=>$v){
            $msgs[$v["id"]] = new DWgramMessage($v);
        }
        return $msgs;
    }
    function getAllMessagesArray($id){
        $msgs = [];
        foreach($this->messages as $k=>$v){
            $msgs[] = new DWgramMessage($v);
        }
        return $msgs;
    }
    function jsonSerialize(){
        return $this->getRawMessages();
    }
}