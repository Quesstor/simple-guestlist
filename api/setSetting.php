<?php

include("engine.php");        

$user = login();
if(!$user || $user["type"] != "admin") die("ACCESS DENIED");

$request = getRequest();

$type = $mysqli->real_escape_string($request->type);
$value = $mysqli->real_escape_string($request->value);

dbquery("UPDATE settings SET value=$value WHERE type='$type'");
     
?>
