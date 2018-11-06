<?php

include("engine.php");        

$user = login();
if(!$user || $user->type != "admin") die("ACCESS DENIED");

$request = getRequest();

DB::query("UPDATE settings SET value=? WHERE type=?", [$request->value, $request->type]);
     
?>
