<?php

include_once("../config/config.php");
include_once "../database/database.php";

if (isset($user)) {
    header("Location: /");
    exit();
}


$request = $_GET;
if(isset($request['login'])){
    $login = $mysqli->real_escape_string($request['login']);

    if(getUserByLogin($login) == null){
        echo "ok";
        exit();
    }
    echo "no";
}


?>