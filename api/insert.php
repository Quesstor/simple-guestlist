<?php
include __DIR__ . "/engine.php";

function insertUser($login, $settings, $vorname, $name, $email, $ip)
{
    if ($name == "") {
        echo "$vorname $name wurde nicht eingetragen, weil der Name leer war.";return;
    }

    if ($vorname == "") {
        echo "$vorname $name wurde nicht eingetragen, weil der Vorname leer war.";return;
    }

    if ($email == "") {
        echo "$vorname $name wurde nicht eingetragen, weil die Emailadresse leer war.";return;
    }

    if (!$settings->duplicates && DB::fetch("SELECT * FROM easylist WHERE vorname=? AND name=? AND email=?", [$vorname, $name, $email])) {
        echo "$vorname $name wurde nicht eingetragen, weil der Name bereits auf der Liste ist.";return;
    }
    DB::query("INSERT INTO easylist  (vorname, name, email, ip) VALUES (?,?,?,?)", [$vorname, $name, $email, $ip]);
    if ($login) {
        $lastid = DB::get_last_insert_id();
        DB::query("UPDATE easylist SET userid=? WHERE id=?", [$login->id, $lastid]);
    }

}

$postdata = file_get_contents("php://input");
$data = json_decode($postdata);

if (isset($data)) {
    $settings = settings();
    if ($settings->maxguests != "0") {
        $count = DB::fetch("SELECT count(*) as c FROM easylist")->c;
        if ($count >= $settings->maxguests) {
            die("Liste ist leider schon voll!");
        }

    }
    $login = false;
    if ($settings->loginrequired != "0") {
        $login = login();
        if (!$login) {
            die("Login failed");
        }
    }
    foreach ($data->names as $key => $data) {
        $vorname = $mysqli->real_escape_string(htmlspecialchars($data->vorname));
        $name = $mysqli->real_escape_string(htmlspecialchars($data->name));
        $email = $mysqli->real_escape_string(htmlspecialchars($data->email));
        $ip = $mysqli->real_escape_string(htmlspecialchars($_SERVER['REMOTE_ADDR']));
        insertUser($login, $settings, $vorname, $name, $email, $ip);
    }
}
