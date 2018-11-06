<?php

include "engine.php";

$user = login();
if (!$user || $user->type != "admin") {
    die("ACCESS DENIED");
}

$request = getRequest();

$username = $mysqli->real_escape_string($request->name);
$userpw = $mysqli->real_escape_string($request->pw);
$usertype = $mysqli->real_escape_string($request->type);
DB::query("INSERT INTO users (name,pw,type) VALUES(?,?,?)", [$username, $userpw, $usertype]);
