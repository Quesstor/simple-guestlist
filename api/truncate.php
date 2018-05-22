<?php
include("engine.php");        

$user = login();
if(!$user || $user["type"] != "admin") die("ACCESS DENIED");

dbquery("TRUNCATE TABLE easylist");
?>
