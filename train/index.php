<?php



include_once("../include/user/user.php");

include_once "../config/config.php";
include_once "../database/database.php";
include_once "../include/models/word/WordModel.php";
include_once "../database/admin.php";


include_once "../include/header/thead.php";


$getr = $_GET;
if (!isset($getr['shuffle'])) {

    $_GET['shuffle'] = 'false';
}
if (!isset($_GET['time'])) {
    $_GET['time'] = 'false';
    $_GET['timeperiod'] = 0;
} else {
    if (!isset($_GET['timeperiod'])) {
        $_GET['timeperiod'] = 0;
    }
}
if (!isset($_GET['count'])) {
    $_GET['count'] = 0;
}
if (!isset($_GET['like'])) {
    $_GET['like'] = 'false';
}

if (!isset($_GET['type'])) {

    echo "Where is type";
    exit();
}

$type = intval($_GET['type']);

function fromStringToBool($string)
{
    $string === 'true' ? 'true' : 'false';
    return $string;
}
?>



<div class="flex-center" id="main-text" style="font-size: 15pt; margin-top: 10px;">

    Выбери правильную букву

</div>


<div class="main-word" id="main-word">

    <div class="count_accept_and_unaccept">
        <div class="accept" id="accept">0</div>
        <div class="accept" style="width: 10px;">:</div>
        <div class="accept" id="unaccept">0</div>
    </div>



    <div class="some-word" id="some-word" lang="ru">

    </div>


    <div class="letter-palace" id="letter-palace">



    </div>




</div>
<div>

    <div class="button" style="margin-top: 10px;" onclick="addNotification()">Закончить тестирование</div>


    <div class="flex-center" style="margin-top: 15px;" onclick="like()">
        <div class="like">
            <img id="img_like" src="../include/res/image/1077035.png">
        </div>
    </div>

</div>


<script>
    var setting = {
        shuffle: <?php echo fromStringToBool($_GET['shuffle']); ?>,
        time: <?php echo fromStringToBool($_GET['time']); ?>,
        timeper: <?php echo intval($_GET['timeperiod']); ?>,
        count: <?php echo intval($_GET['count']); ?>,
        like: <?php echo fromStringToBool($_GET['like']); ?>

    };

    function getTimeByTimerPer(id) {
        if (id == 0) {
            return 5000;
        } else if (id == 1) {
            return 3000;
        } else if (id == 2) {
            return 2000;

        } else if (id == 3) {
            return 1500;
        } else {
            return 1000;
        }
    }
    var version = <?php echo $config['id'];?>;
    var accept = 0;
    var unaccept = 0;

    var globalIndex = 0;

    var mainWordModel = null;
    var arrayWords = new Array();
    var errorWords = new Array();
    var globalLikeMap = new Map();

    var mainId = <?php echo $type; ?>;

    var likeWords = new Array();
    class WordModel {



        constructor(word, answer, letter, type, longAnswer) {

            this.word = word.replace("(", "<br/> (").replace(")", ")<br/>");
            if (type == 3) {
                this.word = word;
            }
            this.answer = answer;
            this.letter = Array.isArray(letter) == true ? letter : letter.split("");
            this.type = type;


        }


        check() {

        }

        doWordStrike(i, w) {
            return mainWordModel.word.substring(0, i) + w.toUpperCase() + mainWordModel.word.substring(i + 1)

        }
        init() {
            var some_word = document.getElementById("some-word");
            var letter_place = document.getElementById("letter-palace");

            if (this.type != 3 && this.type != 6) {

                some_word.innerHTML = "" + (this.word.replace("x", "..."));
                letter_place.innerHTML = "";
                for (var i = 0; i < this.letter.length; i++) {
                    letter_place.innerHTML += "<div class='letter' onclick=\"CheckAnswer('" + this.letter[i].toLowerCase() + "')\">" + this.letter[i].toLowerCase() + "</div>";

                }
            }
            if (this.type == 3) {
                var splitedWord = this.word.split("");
                some_word.innerHTML = "<p>"; // + (this.word.replace("x", "..."));

                for (var i = 0; i < splitedWord.length; i++) {

                    var w = splitedWord[i].toLowerCase();

                    if (w == "у" || w == "е" || w == "ы" || w == "а" || w == "о" || w == "э" || w == "я" ||
                        w == "и" || w == "ю" || w == "ё") {
                        some_word.innerHTML += `<div class="strike-letter" onclick="CheckAnswer(mainWordModel.doWordStrike(` + i + `,'` + w + `'))">` + w + `</div>`;
                    } else {
                        some_word.innerHTML += `<div>` + w + `</div>`;
                    }

                }

                some_word.innerHTML += "</p>";
            }

            if (this.type == 6) {
                letter_place.style = "display:none"
                some_word.style = "line-height:52px;word-break: break-all;margin-top: 30px;height: 128px;display: block;justify-content: flex-start;align-items: center;overflow-x: auto;overflow-y: hidden;padding: 10px;width: auto;height: auto;"
                var splitedWord = this.word.split(" ");
                some_word.innerHTML = ""; // + (this.word.replace("x", "..."));
                for (var i = 0; i < splitedWord.length; i++) {
                    some_word.innerHTML += "<span  style='cursor:pointer;    margin-right: 10px;border: 1px solid;border-radius: 10px;min-width: 110px;padding: 10px;font-size: 15pt;height: 30px;min-height: 30px;width: fit-content;' onclick=\"CheckAnswer(" + i + ")\">" + splitedWord[i].toLowerCase() + "</span>";

                }
            }




            if (setting.time) {
                var object = this;

                this.interval = setInterval(function() {
                    CheckAnswer(".");
                    clearInterval(object.interval);


                }, getTimeByTimerPer(setting.timeper));

            }
            var img_like = document.getElementById("img_like");

            if (globalLikeMap.get(this.word) != null) {
                img_like.src = "../include/res/image/1077086.png";

            } else {
                img_like.src = "../include/res/image/1077035.png";

            }
        }
        answerCheck(e) {
            if (this.interval != null)
                clearInterval(this.interval);

            if (this.type == 4) {
                var ac = this.answer == this.word ? 'д' : 'н'
                if (ac == e) {
                    this.accept = true
                    accept += 1;
                    this.background_change(true);

                } else {
                    this.accept = false
                    unaccept += 4;
                    errorWords.push(this);
                    this.background_change(false);
                }
            }


            if (this.type == 0 || this.type == 1 || this.type == 2 || this.type == 7) {
                if (e == this.answer.toLowerCase()) {
                    accept += 1;
                    this.accept = true
                    this.background_change(true);
                } else {
                    this.accept = false
                    unaccept += 1;
                    errorWords.push(this);
                    this.background_change(false);
                }
            }

            if (this.type == 3) {
                console.log(e)
                if (e == this.answer) {

                    accept += 1;
                    this.accept = true
                    this.background_change(true);
                } else {
                    this.accept = false
                    unaccept += 1;
                    errorWords.push(this);
                    this.background_change(false);
                }
            }

            if (this.type == 6) {
                if (Number(e) == Number(this.answer)) {
                    accept += 1;
                    this.accept = true
                    this.background_change(true);
                } else {
                    this.accept = false
                    unaccept += 1;
                    errorWords.push(this);
                    this.background_change(false);
                }
            }

            var accept_div = document.getElementById("accept");
            accept_div.innerHTML = accept;

            var unaccept_div = document.getElementById("unaccept");
            unaccept_div.innerHTML = unaccept;

            var some_word = document.getElementById("some-word");
            if (this.type != 4 && this.type != 3 && this.type !=6) {
                if (this.word.length < 13) {


                    some_word.innerHTML = "" + ("<span>" + this.word.replace("x", "</span><span class='answer-letter'>" + this.answer.toUpperCase() + "</span><span>").replaceAll("<br/>", "</span><br/><span>") + "</span>");
                } else {
                    some_word.innerHTML = "" + this.word.replace("x", this.answer.toUpperCase())

                }
            }

            if (this.type == 4) {
                some_word.innerHTML = this.answer; //.toUpperCase();
            }

            if (this.type == 3) {
                some_word.innerHTML = "<p>";
                var splited = this.answer.split('');

                for (var i = 0; i < splited.length; i++) {
                    var symbol = splited[i];

                    if (symbol.toUpperCase() == symbol) {
                        some_word.innerHTML += `<div class="strike-letter-answer">` + symbol + `&#x301;</div>`;
                    } else {
                        some_word.innerHTML += `<div>` + symbol + `</div>`;

                    }

                }
                some_word.innerHTML += "</p>"
            }





            var letter_place = document.getElementById("letter-palace");
            //letter_place.innerHTML = "<div class='letter_answer' >" + this.answer.toUpperCase() + "</div>";
            letter_place.innerHTML = "";



        }
        background_change(a) {
            var color = "";
            if (a) {
                color = "#70ff70ad"
            } else {
                color = "#ff7070ad"
            }
            document.body.style.backgroundColor = color;
            var g = this;
            setTimeout(function() {
                g.background_unchange()
            }, 250)
        }
        background_unchange() {
            document.body.style.backgroundColor = "";
        }
        like() {

        }
    }


    function CheckAnswer(a) {
        mainWordModel.answerCheck(a);
        var time = 500;
        if ((mainWordModel.type == 4) && mainWordModel.accept == false) {
            time = 2500;
        }

        if ((mainWordModel.type == 6) && mainWordModel.accept == false) {
            time = 2500;
        }
        setTimeout(function() {
            globalIndex += 1;
            if (globalIndex >= arrayWords.length) {
                globalIndex = 0;
                // accept = 0;
                //unaccept = 0;
                addNotification();
            } else {
                mainWordModel = arrayWords[globalIndex];
                mainWordModel.init();
            }


        }, time)

    }



    async function initWordByType(id) {
        if (id != null) {
            mainId = id;
        } else {
            id = mainId;
            var main_button_close = document.getElementById("main-panel-close-window");
            main_button_close.click();
            accept = 0;
            unaccept = 0;
            globalIndex = 0;
            var main_button_close = document.getElementById("main-panel-close-window");
            main_button_close.click();

            var accept_div = document.getElementById("accept");
            accept_div.innerHTML = accept;

            var unaccept_div = document.getElementById("unaccept");
            unaccept_div.innerHTML = unaccept;

        }
        accept = 0;
        unaccept = 0;
        globalIndex = 0;

        if (localStorage.version != null && localStorage.version != version) {
            localStorage.clear();
        }


        var json = localStorage['json_type_' + id + "_" + version]
        if (json == null || localStorage.version == null || localStorage.version != version) {
            json = await $.get("../team/?type=" + id + "&data=1");
            localStorage['json_type_' + id + "_" + version] = json;
            localStorage.version = version;
            // localStorage.id = id;
        }





        json = JSON.parse(json);

        var jsonArray = json.words;

        for (var i = 0; i < jsonArray.length; i++) {
            var jsonObject = jsonArray[i];
            if (jsonObject.word == "") continue;
            var word = new WordModel(jsonObject.word, jsonObject.fastanswer, jsonObject.letter, jsonObject.type);
            arrayWords.push(word);
        }
        if (setting.like) {
            arrayWords = [];
            arr = Array.from(globalLikeMap.entries());
            if (arr.length == 0) {
                alert("В избранном нет слов");
                window.location.href = "/";
            }
            for (var i = 0; i < arr.length; i++) {
                var jsonObject = Array.from(globalLikeMap.entries())[i][1];
                console.log(jsonObject)
                arrayWords.push(new WordModel(jsonObject.word, jsonObject.answer, jsonObject.letter, jsonObject.type))
            }
        }
        if (setting.shuffle) {
            shuffle(arrayWords)
        }
        if (setting.count != 0) {
            if (setting.count >= arrayWords.length) {
                setting.count = 0

            } else {
                arrayWords = arrayWords.slice(0, setting.count);
            }
        }

        mainWordModel = arrayWords[globalIndex];
        mainWordModel.init();



    }

    function startErrorTest() {
        accept = 0;
        unaccept = 0;
        globalIndex = 0;
        var main_button_close = document.getElementById("main-panel-close-window");
        main_button_close.click();

        var accept_div = document.getElementById("accept");
        accept_div.innerHTML = accept;

        var unaccept_div = document.getElementById("unaccept");
        unaccept_div.innerHTML = unaccept;


        arrayWords = [];
        arrayWords = errorWords;
        errorWords = [];

        shuffle(arrayWords)


        mainWordModel = arrayWords[globalIndex];
        mainWordModel.init();

    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function shuffle(array) {
        let currentIndex = array.length,
            randomIndex;

        // While there remain elements to shuffle.
        while (currentIndex != 0) {

            // Pick a remaining element.
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex--;

            // And swap it with the current element.
            [array[currentIndex], array[randomIndex]] = [
                array[randomIndex], array[currentIndex]
            ];
        }

        return array;
    }



    window.onload = function() {
        var pt = 1.3281472327365;
        var main_word = document.getElementById("main-word");
        main_word.style.height = window.innerHeight - 150 * 2;


        var some_word = document.getElementById("some-word");
        var container = document.getElementById("main-word");


        //some_word.style.marginTop = (window.innerHeight - 300 * 2) / 3
        some_word.style.marginTop = (container.clientHeight) / 3 - 60 * pt / 2 - 25 * pt

        if (mainId == 3) {
            some_word.style.marginTop = (container.clientHeight) / 2 - 60 * pt / 2 - 25 * pt

        }


        var letter_place = document.getElementById("letter-palace");
        letter_place.style.marginTop = 30;
        letter_place.style.height = (window.innerHeight - 50 * 2) / 3.5 - 30;


        var id = mainId;
        likeWords = localStorage['like_' + id + "_" + version];
        globalLikeMap = localStorage['like_map_' + id + "_" + version];


        if (globalLikeMap == null) {
            localStorage['like_map_' + id + "_" + version] = JSON.stringify(Array.from(new Map().entries()));
            globalLikeMap = new Map(JSON.parse(localStorage['like_map_' + id + "_" + version]));

        } else {
            globalLikeMap = new Map(JSON.parse(localStorage['like_map_' + id + "_" + version]));

        }
        if (likeWords == null) {
            localStorage['like_' + id + "_" + version] = new Array();
            likeWords = localStorage['like_' + id + "_" + version];
        }


        initWordByType(mainId);

        var main_text_header = document.getElementById("main-text");
        if (mainId == 4) {
            main_text_header.innerHTML = "Допущен ли ошибка?";
        }

    }


    function addNotification() {
        if (mainWordModel.interval != null) {
            try {
                clearInterval(mainWordModel.interval);
            } catch (e) {};

        }
        var not = document.getElementById("window-controller");
        not.innerHTML = "";
        var element = `
      <?php include_once "../include/res/templates/restart_or_restarterror.php"; ?>
        `;
        not.innerHTML = "" + element.replace("$accept", "" + accept).replace("$unaccept", "" + unaccept);
        var error_restart = document.getElementById("error_restart");
        if (errorWords.length == 0) {
            error_restart.style = "display:none";
        }
    }

    function like() {
        var img_like = document.getElementById("img_like");

        if (globalLikeMap.get(mainWordModel.word) == null) {
            globalLikeMap.set(mainWordModel.word, mainWordModel);
            img_like.src = "../include/res/image/1077086.png";
        } else {
            globalLikeMap.delete(mainWordModel.word);
            img_like.src = "../include/res/image/1077035.png";
        }
        localStorage['like_map_' + mainId + "_" + version] = JSON.stringify(Array.from(globalLikeMap.entries()));

    }
</script>







<?php

include_once "../include/ender/tend.php";
