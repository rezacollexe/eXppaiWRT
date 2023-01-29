<?php
require_once __DIR__.'/src/PHPTelebot.php';
require_once __DIR__.'/src/xc.php';

// Read token & username
function readToken($input){
    $TOKENr = file_get_contents("Xppai.WRT");
    $raw = explode("\n",$TOKENr);
    $TOKEN = $raw[0];
    $USERNAME = $raw[1];
    $owner = $raw[2];
    if ($input == "token") {
        return $TOKEN;
    }elseif($input == "username"){
        return $USERNAME;
    }elseif($input == "owner"){
        return $owner;
    }
}

$bot = new PHPTelebot(readToken("token"), readToken("username"));


function auth(){
    $message = Bot::message();
    $name = $message['from']['first_name'];
    $lastname = $message['from']['first_name'];
    $userId = $message['from']['id'];
    $text = 'You are <code>'.$userId.'</code>-<b>'.$name.' '.$lastname.'</b> not eligible to run this command';
        $options = [
            'parse_mode' => 'html',
            'reply' => true
        ];
    $owner_id=readToken("owner");
    if ($owner_id!=$userId){
        return false;//Bot::sendMessage($text, $options);
    }else{
        return true;
    }
}


// Ping Command
$bot->cmd('/ping',function(){
    if(auth()==true){
        $options = ['parse_mode' => 'html','reply' => true];
        return Bot::sendMessage("internet is up and system is running", $options);
    }
});

// start cmd & cmd list
$bot->cmd('/start',"Welcome to XppaiWRT\n/cmdlist to see all comand\nTelegram Support : @OppaiCyber\nMod By t.me/applehitam");
$bot->cmd('/cmdlist', function () {
	if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>
📁Aria2 Command
 ↳/aria2add      | Add task
 ↳/aria2stats    | Aria2 status
 ↳/aria2pause    | Pause all
 ↳/aria2resume   | Resume all
📁OpenClash Command
 ↳/oc        | OC Information
 ↳/proxies   | Proxies status 
 ↳/rules     | Rule list 
📁MyXL Command 
 ↳/myxl      | Bandwidth usage 
 ↳/setxl 087 | Set default number
📁System Information
 ↳/vnstat    | Bandwidth usage 
 ↳/memory    | Memory status 
 ↳/myip      | Get ip details 
 ↳/speedtest | Speedtest 
 ↳/ping      | Ping bot
 ↳/sysinfo   | System Information
 ↳/modeminfo | Modem Information
 </code>",$options);
}
});

// OpenWRT Command 
$bot->cmd('/proxies', function () {
	if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".Proxies()."</code>",$options);
}
});

$bot->cmd('/vnstat', function ($input) {
	if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("vnstat $input")."</code>",$options);
}
});

$bot->cmd('/memory', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("cat /proc/meminfo | sed -n '1,5p'")."</code>",$options);
    }
});

$bot->cmd('/sysinfo', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("src/plugins/sysinfo.sh -bw")."</code>",$options);
    }
});

$bot->cmd('/modeminfo', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("".shell_exec("src/plugins/modeminfo.sh -bw")."",$options);
    }
});

$bot->cmd('/oc', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("src/plugins/oc.sh")."</code>",$options);
    }
});

$bot->cmd('/myip', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".myip()."</code>",$options);
    }
});

$bot->cmd('/rules', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".Rules()."</code>",$options);
    }
});

$bot->cmd('/speedtest', function () {
    $options = ['parse_mode' => 'html','reply' => true];
    if(auth()==true){
    Bot::sendMessage("<code>Speedtest on Progress</code>", $options);
    return Bot::sendMessage("".Speedtest()."",$options);
    }
});
$bot->cmd('/infogempa', function () {
    $options = ['parse_mode' => 'html','reply' => true];
    
    Bot::sendMessage("<code>Mencari info gempa terbaru</code>", $options);
    return Bot::sendMessage("".infoGempa()."",$options);
    
});

//Myxl cmd
$bot->cmd('/setxl', function ($number) {
    $options = ['parse_mode' => 'html','reply' => true];
    if(auth()==true){
    if ($number == "") {
        Bot::sendMessage("<code>Masukan nomor yang mau di set sebagai default /setxl 087x</code>",$options);
    }else{
        shell_exec("echo '$number' > xl");
        Bot::sendMessage("<code>Nomer $number disetting sebagai default\nSilahkan gunakan cmd /myxl tanpa memasukkan nomor</code>",$options);
    }
}
});

$bot->cmd('/myxl', function ($number) {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    Bot::sendMessage("<code>MyXL on Progress</code>", $options);
    return Bot::sendMessage("<code>".MyXL($number)."</code>",$options);
    }
});
//Myxl cmd end

//Aria2 cmd
$bot->cmd('/aria2add', function ($url) {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("src/plugins/add.sh $url")."</code>",$options);
    }
});

$bot->cmd('/aria2stats', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("src/plugins/stats.sh")."</code>",$options);
    }
});

$bot->cmd('/aria2pause', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("src/plugins/pause.sh")."</code>",$options);
    }
});

$bot->cmd('/aria2resume', function () {
    if(auth()==true){
    $options = ['parse_mode' => 'html','reply' => true];
    return Bot::sendMessage("<code>".shell_exec("src/plugins/resume.sh")."</code>",$options);
    }
});
//Aria2 cmd end

//inline command
$bot->on('inline', function ($cmd,$input) {
    if(auth()==true){
    if($cmd == 'proxies'){
        $results[] = [
        'type' => 'article',
        'id' => 'unique_id1',
        'title' => Proxies(),
        'parse_mode' => 'html',
        'message_text' => "<code>".Proxies()."</code>",
        ];
    }elseif($cmd == 'rules'){
        $results[] = [
        'type' => 'article',
        'id' => 'unique_id1',
        'title' => Rules(),
        'parse_mode' => 'html',
        'message_text' => "<code>".Rules()."</code>",
        ];
    }elseif($cmd == 'myxl'){
        $results[] = [
        'type' => 'article',
        'id' => 'unique_id1',
        'title' => MyXL($input),
        'parse_mode' => 'html',
        'message_text' => "<code>".MyXL($input)."</code>",
        ];
    }
    
    $options = [
        'cache_time' => 3600,
    ];

    return Bot::answerInlineQuery($results, $options);
}
});

$bot->run();
