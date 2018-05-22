<?php
$mysqli = new mysqli("localhost", "root", "", "guestlist") or die("<br>mysql connect failed");

$GLOBALS["mysqli"] = $mysqli;
$GLOBALS["mysqli"]->set_charset("utf8");

function dbquery($query, $multiquery=FALSE){
    $result;
    if($multiquery) $result = $GLOBALS["mysqli"]->multi_query($query);   
    else $result = $GLOBALS["mysqli"]->query($query);   
    return $result;
    
    if ($GLOBALS["mysqli"]->error) {
        http_response_code(500); 
        die("DB Fehler in Query:\n".$query."\n \n".$GLOBALS["mysqli"]->error);
    }
}
function login(){
    $request = getRequest();   

    $name = $GLOBALS["mysqli"]->real_escape_string(@$request->account->name);
    $pw = $GLOBALS["mysqli"]->real_escape_string(@$request->account->pw);

    $res = dbquery("SELECT * FROM users WHERE name='$name' AND pw='$pw'");
    if($user = $res->fetch_assoc()) return $user;
    else return FALSE;
}
function settings(){
    $result = dbquery("SELECT type,value,display FROM settings");
    $settings = array();
    while($row = $result->fetch_assoc()){
        $settings[$row["type"]] = $row;
    }
    return $settings;
}
function fetch_all($result){
    $data = array();
    while($row = $result->fetch_assoc()) array_push($data, $row);
    return $data;
}
function getRequest(){
    $postdata = file_get_contents("php://input");
    return json_decode($postdata);
}