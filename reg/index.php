<?php
include_once "../config/config.php";
include_once "../include/user/user.php";

include_once "../database/database.php";

if (isset($user)) {
    header("Location: /");
    exit();
}


$request = $_GET;

if (isset($request['data'])) {

    if (isset($request['login']) && isset($request['password']) && isset($request['name']) && isset($request['surname'])) {
        $request['login'] = $mysqli->real_escape_string($request['login']);
        $request['password'] = $mysqli->real_escape_string($request['password']);
        $request['name'] = $mysqli->real_escape_string($request['name']);
        $request['surname'] = $mysqli->real_escape_string($request['surname']);
        $request['id'] = 0;
        $request['score'] = 0;
        $request['type'] = 0;
        $user = new User($request);
        if (getUserByLogin( $request['login']) == null) {
            saveUser($user);
            setcookie("login", $request['login'], time() + 60 * 60 * 24 * 365, "/");
            setcookie("password", $request['password'], time() + 60 * 60 * 24 * 365, "/");
        }

        header("Location: /");
        exit();
    }
} else {
?>


    <html>

    <head>
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
                        Регистрация
                    </div>

                </div>

                <form action="/reg" method="GET" style="margin-top: 30px;">
                    <input style="display: none;" type="number" name="data" value="0" />
                    <div>
                        <div class="text-virable">Логин</div>
                        <div class="flex-center">
                            <input onkeydown="await onchanged(this)" type="text" name="login" id="login" class="input-text-virable" placeholder="Придумайте логин" maxlength="20">
                        </div>
                    </div>




                    <div>
                        <div class="text-virable">Имя</div>
                        <div class="flex-center">
                            <input onkeydown="onchanged(this)" onfocus="focus(this)" type="text" name="name" id="name" class="input-text-virable" placeholder="Имя">
                        </div>
                    </div>


                    <div>
                        <div class="text-virable">Фамилия</div>
                        <div class="flex-center">
                            <input onkeydown="onchanged(this)" onfocus="focus(this)" type="text" name="surname" id="surname" class="input-text-virable" placeholder="Фамилия">
                        </div>
                    </div>


                    <div>
                        <div class="text-virable">Пароль</div>
                        <div class="flex-center">
                            <input onkeydown="onchanged(this)" onfocus="focus(this)" id="password" name="password" type="password" class="input-text-virable" placeholder="Password" maxlength="20">
                        </div>
                    </div>

                    <div class="flex-left" style="margin-top: 10px">
                        <a href="/auth" style="font-size: 15pt">Авторизация</a>
                    </div>

                    <div class="flex-right">
                        <a class="button-virable" onclick="send(this)">Регистрация</a>
                    </div>
                </form>
            </div>

        </div>

        <script>
            window.onload = async function() {


            }

            function focus(a) {
                a.style = "";
            }
            async function onchanged(a) {
                focus(a)
                if (await checkLogins()) {
                    document.getElementById("login").style = "background-color: rgba(35, 243, 35, 0.68);";
                } else {
                    document.getElementById("login").style = "background-color: rgba(243, 35, 35, 0.68);"

                }
                document.getElementById("surname").style = "";
                document.getElementById("name").style = "";
                document.getElementById("password").style = "";


                var name = document.getElementById("name").value


                var surname = document.getElementById("surname").value


                var password = document.getElementById("password").value


                if (name.length < 3) {
                    document.getElementById("name").style = "background-color: rgba(243, 35, 35, 0.68);"


                } else {
                    document.getElementById("name").style = " background-color: rgba(35, 243, 35, 0.68);"


                }


                if (surname.length < 3) {
                    document.getElementById("surname").style = "background-color: rgba(243, 35, 35, 0.68);"



                } else {
                    document.getElementById("surname").style = "background-color: rgba(35, 243, 35, 0.68);"

                }



                if (checkValid(password) == false) {
                    document.getElementById("password").style = "background-color: rgba(243, 35, 35, 0.68);"


                } else {

                    document.getElementById("password").style = "background-color: rgba(35, 243, 35, 0.68);"


                }


            }

            async function send(a) {
                if (await checkLogin()) {
                    document.getElementById("login").style = "background-color: rgba(35, 243, 35, 0.68);";
                    document.getElementById("surname").style = "";
                    document.getElementById("name").style = "";
                    document.getElementById("password").style = "";


                    var name = document.getElementById("name").value


                    var surname = document.getElementById("surname").value


                    var password = document.getElementById("password").value


                    if (name.length < 3) {
                        document.getElementById("name").style = "background-color: rgba(243, 35, 35, 0.68);"
                        return;

                    } else {
                        document.getElementById("name").style = " background-color: rgba(35, 243, 35, 0.68);"


                    }


                    if (surname.length < 3) {
                        document.getElementById("surname").style = "background-color: rgba(243, 35, 35, 0.68);"

                        return;

                    } else {
                        document.getElementById("surname").style = "background-color: rgba(35, 243, 35, 0.68);"

                    }



                    if (checkValid(password) == false) {
                        document.getElementById("password").style = "background-color: rgba(243, 35, 35, 0.68);"
                        alert("Пароль может состоять только из латинских букв верхнего и нижнего регистра и цифр!Минимум 3 символа,максимум 14!Пароль не должен быть простым!")

                        return;
                    } else {

                        document.getElementById("password").style = "background-color: rgba(35, 243, 35, 0.68);"


                    }




                    a.parentElement.parentElement.submit()

                } else {


                    document.getElementById("login").style = "background-color: rgba(243, 35, 35, 0.68);"


                }

            }

            function checkValid(str) {
                //var regex = /^[\w-]{4,10}$/i;
                // var regex = new RegExp("[a-zA-Z]\\w{3,20}")
                var regex = new RegExp("^[a-zA-Z][a-zA-Z0-9-_\\.]{3,20}$");
                return regex.test(str)
            }

            function checkMail(mail) {
                let regexp = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
                return regexp.test(mail)
            }

            async function checkLogin() {
                var val = document.getElementById("login").value;
                var html = await $.post("/checklogin?login=" + val);

                if (html == "ok") {
                    return true;
                }


                if (html == "exist") {
                    alert("Пользователь с таким логином создан")
                }
                if (html == "invalid") {
                    alert("Логин может состоять только из латинских букв верхнего и нижнего регистра и цифр!Минимум 3 символа,максимум 14!")
                }

                return false;

            }

            async function checkLogins() {
                var val = document.getElementById("login").value;
                var html = await $.get("/checklogin?login=" + val);

                if (html == "ok") {
                    return true;
                } else



                    return false;

            }
        </script>



    </body>

    </html>





<?php
}

?>