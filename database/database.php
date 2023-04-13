<?php


$mysqli = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
mysqli_set_charset($mysqli, "utf8");
if (!$mysqli) {
    die("Database connect fail!");
}


function getWordsDictionery($type)
{

    global $mysqli;
    $reault = mysqli_query($mysqli, "SELECT * FROM `words` WHERE `type` = {$type}");
    $array = array();
    $param = array();
    while ($row = mysqli_fetch_assoc($reault)) {
        $model = new WordModel($row);
        array_push($array, $model);
    }
    $param['words'] = $array;



    return $param;
}

function login($login, $password)
{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `login` = '{$login}' AND `password` = '{$password}'");

    while ($row = mysqli_fetch_assoc($result)) {
        return new User($row);
    }
    return null;
}

function getUserByLogin($login)
{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `login` = '{$login}'");

    while ($row = mysqli_fetch_assoc($result)) {
        return new User($row);
    }
    return null;
}
function saveUser($user)
{
    global $mysqli;
    $sql = "INSERT INTO `users`(`id`, `login`, `password`, `name`, `surname`, `score`,`type`) VALUES " . $user->toQuery();
    //echo $sql;
    mysqli_query($mysqli, $sql);
}
if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {

    $login = $mysqli->real_escape_string($_COOKIE['login']);
    $pass = $mysqli->real_escape_string($_COOKIE['password']);

    $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `login` = '{$login}' AND `password` = '{$pass}'");
    $row = mysqli_fetch_assoc($result);
    $user =  new User($row);
}


function generateTest($request)
{
    global $mysqli;
    $testId = createTest($request['timeperiod']);

    $array = array();
    $res = mysqli_query($mysqli, "SELECT * FROM `words` WHERE `type` = {$request['type']} ORDER BY RAND() LIMIT {$request['count']}");
    while ($row = mysqli_fetch_assoc($res)) {
        array_push($array, $row['id']);
    }
    for ($i = 0; $i < count($array); $i++) {
        mysqli_query($mysqli, "INSERT INTO `tasks`(`id`, `testId`, `wordId`) VALUES (NULL,{$testId},{$array[$i]})");
    }
}

function createTest($timeperiod)

{
    $id = 0;

    global $mysqli;
    mysqli_query($mysqli, "INSERT INTO `tests`(`id`, `time`) VALUES (NULL,{$timeperiod})");
    return mysqli_insert_id($mysqli);
}

function getTest($id)
{
    global $mysqli;
    $result = mysqli_query($mysqli,"SELECT * FROM `tasks` WHERE `testId` = {$id}");
    $array = array();
    $param = array();
   
    while($row = mysqli_fetch_assoc($result)){
        $reault = mysqli_query($mysqli, "SELECT * FROM `words` WHERE `id` = {$row['wordId']} LIMIT 1");
    
        $row = mysqli_fetch_assoc($reault);
        $model = new WordModel($row);
        array_push($array, $model);
        
      
    }

    $param['words'] = $array;

    return $param;
    
}
