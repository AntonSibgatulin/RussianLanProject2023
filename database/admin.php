<?php



function saveWord($word){
    global $mysqli;

    if(checkWord($word)!=0){
        deleteWord($word);
    }
    mysqli_query($mysqli,"INSERT INTO `words`(`id`, `word`, `answer`, `type`, `letter`, `someWord`,`fastanswer`) VALUES ".$word->toQuery());

   
    return mysqli_insert_id($mysqli);

}

function checkWord($word){
    global $mysqli;
    if($word->type == 3){
        $result = mysqli_query($mysqli,"SELECT COUNT(*) as total from `words` WHERE `answer` = '{$word->answer}'  AND `type` = {$word->type}");
    
    }else{
    $result = mysqli_query($mysqli,"SELECT COUNT(*) as total from `words` WHERE `someWord` = '{$word->someWord}'  AND `type` = {$word->type}");
    }
    $data = mysqli_fetch_assoc($result);
    return $data['total'];

}

function checkWordByWord($word,$type){
    global $mysqli;
    $result = mysqli_query($mysqli,"SELECT COUNT(*) as total from `words` WHERE `someWord` = '{$word}' AND `type` = {$type}");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];

}


function deleteWord($word){
    global $mysqli;
    mysqli_query($mysqli,"DELETE FROM `words` WHERE `someWord` = '{$word->someWord}'");
}