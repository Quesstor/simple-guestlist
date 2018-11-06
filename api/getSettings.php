<?php
include "engine.php";

$settings = settings();
$data = array();
$data["loginrequired"] = $settings->loginrequired == "0" ? false : true;
$data["full"] = false;

if ($settings->maxguests != "0") {
    $count = DB::fetch("SELECT count(*) AS c FROM easylist")->c;
    if ($count >= $settings->maxguests) {
        $data["full"] = true;
    }

}
echo json_encode($data);
