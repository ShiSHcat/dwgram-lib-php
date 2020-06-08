<?php
class DWgramStats implements JsonSerializable{
    protected $response = [];
    function __construct($resp_object){
        $this->response = $resp_object;
    }
    function getAssoc(){
        return $this->response;
    }
    function getAPI_online(){
        return $this->response["API_online"];
    }
    function getMyIP(){
        return $this->response["your_ip"];
    }
    function getMedia_dwgrammed_counter(){
        return $this->response["media_dwgrammed_counter"];
    }
    function getDwpagesreg_iplogging_status(){
        return $this->response["dwpagesreg_iplogging_status"];
    }
    function getVisitor_number(){
        return $this->response["visitor_number"];
    }
    function getLast_reboot_API_server(){
        return $this->response["last_reboot_API_server"];
    }
    public function jsonSerialize(){
        return $this->response;
    }
}