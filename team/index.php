<?php

$_POST['data'] = 1;


include_once "../include/user/user.php";

include_once "../config/config.php";
include_once "../database/database.php";
include_once "../include/models/word/WordModel.php";
include_once "../database/admin.php";

include_once "../include/header/thead.php";


if(isset($_GET['type'])){

$param = getWordsDictionery(intval($_GET['type']));
echo json_encode($param);
exit();
}
else{
    echo "Where is type";
    
}



include_once "../include/ender/tend.php";

?>