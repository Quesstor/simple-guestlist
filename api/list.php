<?php
include("engine.php");        

$user = login();
if(!$user || $user->type != "admin") die("ACCESS DENIED");

$list = DB::fetch_all("SELECT * FROM easylist");
$users = DB::fetch_all("SELECT * FROM users");
$settings = DB::fetch_all("SELECT * FROM settings");

echo json_encode(array("user" => $user, "list"=>$list, "users"=>$users, "settings" => $settings));     
?>
