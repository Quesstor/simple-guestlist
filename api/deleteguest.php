<?php
include("engine.php");        

$user = login();
if(!$user || $user->type != "admin") die("ACCESS DENIED");

$request = getRequest();

$id = $mysqli->real_escape_string($request->id);
DB::query("DELETE FROM easylist WHERE ID=? LIMIT 1", [$id]);

?>
