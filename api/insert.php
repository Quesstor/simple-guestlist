<?php
    $postdata = file_get_contents("php://input");
    $data = json_decode($postdata);
    if( isset($data) )
    {
        include("engine.php");
        $settings = settings();
        if ($settings["maxguests"]["value"]!="0") {
            $result = dbquery("SELECT * FROM easylist");
            if($result->num_rows > $settings["maxguests"]["value"]) die("Liste ist leider schon voll!");
        }
        if($settings["loginrequired"]["value"]!="0"){
            $user = login();
            if(!$user) die("Login failed");
        }
        foreach ($data->names as $key => $data) {
            $vorname = $mysqli->real_escape_string(htmlspecialchars($data->vorname));
            $name = $mysqli->real_escape_string(htmlspecialchars($data->name));
	        $email = $mysqli->real_escape_string(htmlspecialchars($data->email));
	        $ip = $mysqli->real_escape_string(htmlspecialchars($_SERVER['REMOTE_ADDR']));
            if($name!="" && $vorname!="" && $email!=""){
                dbquery("INSERT INTO easylist  (vorname, name, email, ip) VALUES ('$vorname', '$name', '$email', '$ip')");
                if($user){
                    $userid = $user["id"];
                    $lastid = $mysqli->insert_id;
                    dbquery("UPDATE easylist SET userid=$userid WHERE id=$lastid");
                } 
            }else
                echo "$vorname $name wurde nicht eingetragen, da Vorname, Name oder Email leer war. ";
        }
    }
?>