<?php
include("engine.php");

$user = login();
if($user) echo json_encode($user);
else http_response_code(400); 
