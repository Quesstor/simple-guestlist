<?php
include("engine.php");

$settings = settings();
$data = array();
$data["loginrequired"] = $settings["loginrequired"]["value"]=="0"?FALSE:TRUE;
$data["full"] = FALSE;

if ($settings["maxguests"]["value"]!="0") {
    $result = dbquery("SELECT * FROM easylist");
    if($result->num_rows >= $settings["maxguests"]["value"]) 
        $data["full"]=TRUE;
}
echo json_encode($data);
