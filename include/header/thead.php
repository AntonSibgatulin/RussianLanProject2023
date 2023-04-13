<?php




include_once 'func.php';

$request = $_POST;

if (!isset($request['data'])) {

?>

    <html lang="ru-RU">

    <head>
        <title>Русский ЕГЭ-2023</title>

        <meta charset="UTF-8">
        <meta name="description" content="Тысячи слов с ответами для подготовки к ЕГЭ–2023 по русскому языку. Система тестов для подготовки и самоподготовки к ЕГЭ.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-TileColor" content="#D83434">
        <meta name="msapplication-TileImage" content="../../../../include/res/image/header/sicon.png">

        <!-- <script src="https://code.jquery.com/jquery-latest.js"></script>-->

        <script src="	https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

        <script src="../../../../include/res/js/main.js"></script>



        <link rel="icon" type="image/png" href="../../../../include/res/image/header/sicon.png">
        <link rel="shortcut icon" type="image/png" href="../../../../include/res/image/header/sicon.png">
        <link rel="Bookmark" type="image/png" href="../../../../include/res/image/header/sicon.png">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.css" />
        <link href="../../include/res/css/index.css?id=<?php echo rand(0, 99999995679); ?>" rel="stylesheet">


        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function(m, e, t, r, i, k, a) {
                m[i] = m[i] || function() {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                for (var j = 0; j < document.scripts.length; j++) {
                    if (document.scripts[j].src === r) {
                        return;
                    }
                }
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(92586967, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/92586967" style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
    </head>







    <body>


        <script>
            function moveToPage() {
                var typeValue = <?php echo rand(0, 1); ?>;
                window.location.href = "/train/?type=" + typeValue + "&count=15&shuffle=true"
            }

            function likeMoveToPage() {
                var typeValue = <?php echo rand(0, 1); ?>;
                window.location.href = "/train/?type=" + typeValue + "&shuffle=true&like=true"
            }

            function showMenuItems(id) {
                $("#menuItems" + id).show(800);
            }
        </script>


        <header>
            <a class="menu" onclick="openmenu()">
                <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false">
                    <g class="style-scope yt-icon">
                        <path d="M21,6H3V5h18V6z M21,11H3v1h18V11z M21,17H3v1h18V17z" class="style-scope yt-icon"></path>
                    </g>
                </svg>
            </a>
            <a href="/" class="logo-header">
                <img src="../../../../include/res/image/system/icon.png">

                <!--<img src="https://inf-ege.sdamgia.ru/img/headers/logo.svg">-->
                <container-left>
                    <text>
                        Русский–2023
                    </text>
                </container-left>
            </a>


        </header>



        <div id="mainController">



            <div id="leftPanel">



                <div class="forms">
                    <a href="/">
                        <div class="element">
                            <div class="icon">
                                <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;">
                                    <g class="style-scope yt-icon">
                                        <path d="M4,10V21h6V15h4v6h6V10L12,3Z" class="style-scope yt-icon" />
                                    </g>
                                </svg>
                            </div>
                            Главная
                        </div>
                    </a>

                    <a href="/rating">
                        <div class="element">
                            <div class="icon">
                                <img src="https://www.iconpacks.net/icons/2/free-rating-star-icon-2793-thumb.png">
                            </div>
                            Рейтинг
                        </div>
                    </a>


                    <a onclick="likeMoveToPage()">
                        <div class="element">
                            <div class="icon">
                                <img src="../../../../include/res/image/1077086.png">
                            </div>
                            Избранное
                        </div>
                    </a>

                    <a href="/theorys">
                        <div class="element">
                            <div class="icon">
                                <img src="../../../../include/res/image/system/sciense.svg">
                            </div>
                            Теория
                        </div>
                    </a>


                </div>


                <div class="forms">



                    <div class="element">
                        <div class="icon">
                            <img src="../../../../include/res/image/system/laptop.svg">
                        </div>
                        Информатика
                    </div>

                </div>



                <?php
                if (isset($user)) {
                ?>

                    <div class="forms" style="border-bottom: none;">
                        <a href="/exit">
                            <div class="element">
                                <div class="icon">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3094/3094700.png">
                                </div>
                                Выход
                            </div>
                        </a>

                    </div>


                <?php
                } else {
                ?>
                    <div class="forms">
                        <a href="/auth">
                            <div class="element">
                                <div class="icon">
                                    <img src="../../../../include/res/image/system/authentication-icon.svg">
                                </div>
                                Вход
                            </div>
                        </a>

                        <a href="/reg">
                            <div class="element">
                                <div class="icon">
                                    <img src="../../../../include/res/image/system/registration-icon.svg">
                                </div>
                                Регистрация
                            </div>
                        </a>

                    </div>

                <?php
                }
                ?>


            </div>



            <div id="container">

            <?php

        }

            ?>