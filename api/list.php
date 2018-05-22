<?php
include("engine.php");        

$user = login();
if(!$user || $user["type"] != "admin") die("ACCESS DENIED");

$result = $mysqli->query("SELECT * FROM easylist");
$list = fetch_all($result);
$result = $mysqli->query("SELECT * FROM users");
$users = fetch_all($result);
$result = $mysqli->query("SELECT * FROM settings");
$settings = fetch_all($result);

echo json_encode(array("user" => $user, "list"=>$list, "users"=>$users, "settings" => settings()));     
?>
