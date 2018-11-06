<?php
include(__DIR__."/DB.php");

$GLOBALS["settings"] = parse_ini_file(__DIR__."/settings.ini", true);

$mysqli = new mysqli($GLOBALS["settings"]["DB"]["url"], $GLOBALS["settings"]["DB"]["name"], $GLOBALS["settings"]["DB"]["pw"], $GLOBALS["settings"]["DB"]["db"]) or die("<br>mysql connect failed"); //ASADF

function login(){
    $request = getRequest();   

    $name = $request->account->name;
    $pw = $request->account->pw;

    if($user = DB::fetch("SELECT * FROM users WHERE name=? AND pw=?", [$name, $pw])) return $user;
    else return FALSE;
}
function settings(){
    $results = DB::fetch_all("SELECT type,value,display FROM settings");
    $settings = array();
    foreach($results as $row){
        $settings[$row->type] = $row->value;
    }
    return (object) $settings;
}
function getRequest(){
    $postdata = file_get_contents("php://input");
    return json_decode($postdata);
}