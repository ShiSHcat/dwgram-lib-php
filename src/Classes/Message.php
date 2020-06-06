<?php
class DWgramMessage implements JsonSerializable{
    protected $msg_content = "";
    protected $mediaURL = "";
    protected $sURL = "";
    protected $smURL = "";
    protected $id = 0;
    protected $has_media = false;
    protected $is_sqstring = true;
    protected $filename = "";
    protected $type = "";
    function __construct($msg_object){
        $this->msg_content = $msg_object["message"];
        $this->id = $msg_object["id"];
        $this->sURL = $msg_object["s_url"];
        if($msg_object["has_media"]) {
            $this->has_media = true;
            if(isset($msg_object["mediaURL"])) {
                $this->is_sqstring = false;
                $this->mediaURL = $msg_object["mediaURL"];
            }
            $this->smURL = $msg_object["sm_url"];
            $this->filename = $msg_object["fname"];
            $this->type = $msg_object["fname"];
        }
    }
    public function getText(){
        return $this->msg_content;
    }
    public function getID(){
        return $this->id;
    }
    public function getTextURL(){
        return $this->has_media?$this->smURL:$this->sURL;
    }
    public function hasMedia(){
        return $this->has_media;
    }
    public function getMediaSURL(){
        if($this->has_media) {
            $this->sURL;
        } else {
            throw new Exception("DWGram API wrapper: no media available for this message.");
        }
    }
    public function getMediaType(){
        if($this->has_media) {
            $this->type;
        } else {
            throw new Exception("DWGram API wrapper: no media available for this message.");
        }
    }
    public function getFilename(){
        if($this->has_media) {
            if($this->filename !== "") return $this->filename;
            else return NULL;
        } else {
            throw new Exception("DWGram API wrapper: no media available for this message.");
        }
    }
    public function getMediaURL(){
        if($this->has_media) {
            if(!$this->is_sqstring)
                return $this->mediaURL;
            else 
                return $this->sURL;
        } else {
            throw new Exception("DWGram API wrapper: no media available for this message.");
        }
    }
    public function is_s(){
        return $this->is_sqstring;
    }
    public function jsonSerialize(){
        if($this->has_media&&(!$this->is_sqstring)) return ["message"=>$this->msg_content,"has_media"=>true,"mediaURL"=>$this->mediaURL,"s_url"=>$this->sURL,"sm_url"=>$this->smURL,"fname"=>$this->filename,"type"=>$this->type,"id"=>$this->id];
        elseif ($this->has_media) return ["message"=>$this->msg_content,"has_media"=>true,"s_url"=>$this->sURL,"sm_url"=>$this->smURL,"fname"=>$this->filename,"type"=>$this->type,"id"=>$this->id];
        else return ["message"=>$this->msg_content,"has_media"=>false,"s_url"=>$this->sURL,"id"=>$this->id];
    }
}