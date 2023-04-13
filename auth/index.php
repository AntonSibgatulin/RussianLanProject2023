<?php
include_once "../config/config.php";
include_once "../include/user/user.php";
include_once "../database/database.php";

if(isset($user)){
    header("Location: /");
    exit();
}

$request =$_GET;

if(isset($request['data'])){
   
    if(isset($request['login']) && isset($request['password'])){
        $login = $mysqli->real_escape_string($request['login']);
        $password = $mysqli->real_escape_string($request['password']);
        if(login($login,$password)!=null){
            setcookie("login",$request['login'],time()+60*60*24*365,"/");
            setcookie("password",$request['password'],time()+60*60*24*365,"/");
            header("Location: /");
            exit();
        }else{
            header("Location: /auth?auth=false");
            exit();
        }

   }


}else{
    if(isset($_GET['auth'])){
        ?>
<script>
    alert("Не правильный логин или пароль!")
</script>
        <?php
    }
?>

<html><head>
    <title>Авторизация</title>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.css">
 
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../include/res/css/index.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-latest.js">

    </script><!--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>-->
    <script src="../../include/res/js/main.js"></script>
   
</head>
<body>


<div class="block-display">
    <div class="window-create" style="justify-content: center;
    align-items: start;
    justify-items: center;
    align-content: center;">

        <div class="panel-close-window">

        </div>

        <!--<div class="close-window" onclick="closeWindow(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <g id="close">
                    <path id="x"
                          d="M18.717 6.697l-1.414-1.414-5.303 5.303-5.303-5.303-1.414 1.414 5.303 5.303-5.303 5.303 1.414 1.414 5.303-5.303 5.303 5.303 1.414-1.414-5.303-5.303z"></path>
                </g>
            </svg>
        </div>
        -->


        <div class="flex-center">

            <div class="text-header">
                Авторизация
            </div>

        </div>

        <form action="/auth" method="GET" style="margin-top: 30px;">
        <input style="display: none;" type="number" name="data" value="0"/>
            <div>
                <div class="text-virable">Логин или пароль</div>
                <div class="flex-center">
                    <input type="text" name="login" id="name_of_virable" class="input-text-virable" placeholder="Login or mail">
                </div>
            </div>


            <div>
                <div class="text-virable">Пароль</div>
                <div class="flex-center">
                    <input id="value_of_virable" name="password" type="password" class="input-text-virable" placeholder="Password">
                </div>
            </div>

            <div class="flex-left" style="margin-top: 10px">
                <a href="/reg" style="font-size: 15pt">Регистрация</a>
            </div>

            <div class="flex-right">
                <a class="button-virable" onclick="this.parentElement.parentElement.submit()">Авторизация</a>
            </div>
        </form>
    </div>

</div>


</body></html>






<?php
}

?>