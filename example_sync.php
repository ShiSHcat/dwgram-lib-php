<?php
# include DWgramSync
include __DIR__."/src/sync.php"; # change with the actual location of /src/sync.php for your script
# instantiate DWgramSync
$dws = new DWgramSync();
# get last 100 msgs in a chat
$msgs = $dws->getChat(["username"=>"shishcatnews"]); #parameters can be found on the docs page
# get a message by id
$msg = $msgs->getMessageByID(2);;
# let's echo it's contents
echo $msg->getText();
# now let's get every message
$msgs_array = $msgs->getAllMessages(); #key is the ID, ascending order
#let's iterate over the associative array
foreach($msgs_array as $k=>$v){
    # if you want to skip medias with no caption use if($v->getText() == "") continue;
    # if you want to skip medias at all use if($v->hasMedia) continue;
    echo "@shishcatnews said: \n".$v->getText();
    if($v->hasMedia()) echo "\nATTACHMENT: ".$v->getMediaURL();
    echo "\n\n\n";
}
# IF YOU NEED HELP DON'T HESITATE TO CONTACT US ON @dwgramchat!
