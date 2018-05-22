<?php

include("engine.php");        

$user = login();
if(!$user || $user["type"] != "admin") die("ACCESS DENIED");

$request = getRequest();

$userid = $mysqli->real_escape_string($request->id);
dbquery("DELETE FROM users WHERE id=$userid");
     
?>
