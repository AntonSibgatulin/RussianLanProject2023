<?php
include_once "../include/user/user.php";
include_once "../config/config.php";
include_once "../database/database.php";
include_once "../include/models/word/WordModel.php";
include_once "../database/admin.php";





if (!isset($user) || $user->type == 0) {
    header("Location: /");
    exit();
}

include_once "../include/header/thead.php";

if (isset($request['data'])) {

    if ($request['data'] == 1) {
        try {


            $request['id'] = null;
            $request['word'] = $mysqli->real_escape_string($request['word']);
            $request['answer'] = $mysqli->real_escape_string($request['answer']);
            $request['letter'] = $mysqli->real_escape_string($request['letter']);
            $request['someWord'] = $mysqli->real_escape_string($request['someWord']);

            $wordModel = new WordModel($request);
            $id = saveWord($wordModel);
            echo $id;
        } catch (Exception $e) {
            echo $e;
            die("Не все данные введены");
        }
    }
    if ($request['data'] == 2) {
        if (isset($request['word']) && strlen($request['word']) > 3) {

            echo checkWordByWord($request['word'], $request['type']);
        }
    }





    exit();
}





?>


<div class="flex-center">
    <textarea id="words" class="input-text-virable" style="height:130px;font-size:15px;"></textarea>

</div>

<div class="flex-left" style="margin-top:10px;">
    <a class="button" style="margin-top:10px;padding:5px 15px;" onclick="nextWord(true)">Следущее слово</a>
    <a class="button" style="margin-top:10px;padding:5px 15px;" onclick="nextWord(false)">Пропустить слово</a>
    <a class="button" style="margin-top:10px;padding:5px 15px;" onclick="clearinput()">Очистить</a>
</div>

<div class="flex-center">
    <h1>Добавление слова</h1>
</div>

<form id="form">
    <div class="flex-left">
        <input id="word" type="text" class="input-text-virable">
    </div>

    <div id="output" class="flex-center" style="margin-top:10px;font-size:25pt;">



    </div>

    <div class="flex-left">
        <input id="wordAccept" name="word" type="text" class="input-text-virable">
    </div>



    <div class="flex-left">
        <input id="answer" name="answer" type="text" class="input-text-virable">
    </div>


    <div class="flex-left">
        <input id="someWord" name="someWord" type="text" class="input-text-virable">
    </div>

    <div class="flex-left">
        <input id="letter" name="letter" type="text" class="input-text-virable">
    </div>



    <div class="flex-left">
        <input id="fastanswer" name="fastanswer" type="text" class="input-text-virable">
    </div>

    <div class="flex-center pre-menu">

        <div class="flex-left">
            <input type="radio" name="type" id="korni" checked value="0">
            <label for="korni">Корни</label>
        </div>


        <div class="flex-left">
            <input type="radio" name="type" id="prist" value="1">
            <label for="prist">Приставки</label>
        </div>


        <div class="flex-left">
            <input type="radio" name="type" id="suff" value="2">
            <label for="suff">Суффиксы</label>
        </div>


        <div class="flex-left">
            <input type="radio" name="type" id="udar" value="3">
            <label for="udar">Ударения</label>
        </div>


        <div class="flex-left">
            <input type="radio" name="type" id="err" value="4">
            <label for="err">Ошибки в слов.</label>
        </div>


        <div class="flex-left">
            <input type="radio" name="type" id="error" value="5">
            <label for="error">Ошибки</label>
        </div>


        <div class="flex-left">
            <input type="radio" name="type" id="delete" value="6">
            <label for="delete">Исключить лишнее слово</label>
        </div>


        
        <div class="flex-left">
            <input type="radio" name="type" id="ne" value="7">
            <label for="ne">Правописание суффиксов и окончаний глагольных форм</label>
        </div>




    </div>


    <input type="submit" value="Создать" id="submit" class="button" style="margin-top:10px;padding:5px 15px;">
</form>

<script>
    var letterArray = new Array();
    var main_word = "";


    var sogl = ["а", "я", "у", "ю", "о", "е", "и", "ы"];

    var znaks = ["ь", "ъ"];
    var prist = ["а", "о", "е", "и", "д", "т", "з"];

    var suf = ["и", "е", "а", "о", "з", "с"];


    function initAdminInputWord() {

        var wordinput = document.getElementById("word");
        wordinput.addEventListener('input', inputHandler);
        wordinput.addEventListener('propertychange', inputHandler); // for IE8


    }

    function setLetter(letter, i) {
        var index = document.querySelector("input[name=type]:checked").value;
        
        var word = "";
        var answer = "";

        for (var j = 0; j < i; j++) {
            word += (letterArray[j].toLowerCase());
            answer += (letterArray[j].toLowerCase());
        }

        word += "x";
        answer += (letterArray[i].toUpperCase());

        for (var j = i + 1; j < letterArray.length; j++) {
            word += (letterArray[j].toLowerCase());
            answer += (letterArray[j].toLowerCase());
        
        }


        if(index == 6){
            word = document.getElementById("word").value
            answer = ""+i;
        }


        var wordAccept = document.getElementById("wordAccept");
        var answerInput = document.getElementById("answer");
        var someWord = document.getElementById("someWord");
        var fastanswer = document.getElementById("fastanswer")
        answerInput.value = letterArray[i];
        wordAccept.value = word;
        fastanswer.value = answer;

        someWord.value = word//answer.toLowerCase();


        var letterInput = document.getElementById("letter");
        letterInput.value = checkLetter(letter.toLowerCase());

        nextWord(true)
    }

    function checkLetter(letter) {
        letter = letter.toLowerCase();
        var need = "";
        var index = document.querySelector("input[name=type]:checked").value;
        if ((letter == "и" || letter == 'е' || letter == "я") && index == 0) {
            need += "иея"
        }

        if ((letter == "о" || letter == 'а' || letter == 'ё') && index == 0) {
            need += "оаё"
        }

        if ((letter == "и" || letter == 'е') && index == 0) {
            need = "ие"
        }


        if ((letter == "и" || letter == 'е' || letter == "ы") && index == 1) {
            need += "ыие"
        }

        if ((letter == "д" || letter == 'т') && index == 1) {
            need += "дт"
        }

        if ((letter == "з" || letter == 'с') && index == 1) {
            need += "зс"
        }
        if ((letter == "ь" || letter == 'ъ') && index == 1) {
            need += "ьъ"
        }

        if ((letter == "а" || letter == 'о') && index == 1) {
            need += "ао"
        }




        
        if ((letter == "и" || letter == 'е' || letter == "ы") && index == 7) {
            need += "ие"
        }

        if ((letter == "у" || letter == 'а') && index == 7) {
            need += "уа"
        }

        if ((letter == "ю" || letter == 'я') && index == 7) {
            need += "яюе"
        }
        if ((letter == "ь" || letter == 'ъ') && index == 7) {
            need += "ьъ"
        }
/*
        if ((letter == "а" || letter == 'о' || letter == "ё") && index == 7) {
            need += "ао"
        }
        */

        





        if ((letter == "и") && index == 2) {
            need += "ие"
        }
        if ((letter == "с" || letter == 'з' || letter == 'ц') && index == 2) {
            need += "сзц"
        }

        if ((letter == "о" || letter == 'а' || letter == 'е') && index == 2) {
            need += "оае"
        }

        if(index == 6){
            need = "NaN";
        }
        return need;



    }

    const inputHandler = function(e) {
        var mainId = document.querySelector("input[name=type]:checked").value;

        updateInput(e.target.value, mainId);
    }

    function updateInput(data, type) {
        var style = '';

        console.log(type)
        var output = document.getElementById("output");
        var result = data
        var split = result.split("");
        if (type == 4) {
            split = result.split(" ")
            style = "style= 'font-size:15pt;'"
        }
        output.innerHTML = "";
        letterArray = new Array();


        if (type != 6) {
            for (var i = 0; i < split.length; i++) {
                letterArray.push(split[i])

                output.innerHTML += "<div class='letter ' " + style + " onclick=\"setLetter('" + split[i] + "'," + i + ")\">" + split[i].toLowerCase() + "</div>";
            }
        }

        if (type == 6) {
            split = result.split(" ");
            for (var i = 0; i < split.length; i++) {
                letterArray.push(split[i])

                output.style = `display: flex;width: 100%;overflow-x: auto;margin-top: 10px;    justify-content: flex-start;`;

                output.innerHTML += "<a class='letter ' " + style + " onclick=\"setLetter('" + split[i] + "'," + i + ")\">" + split[i].toLowerCase() + "</a>";
            }
        }
        main_word = result;
    }



    function sendSubmit() {

    }


    initAdminInputWord();



    $("#form").submit(function(e) { // Устанавливаем событие отправки для формы с id=form
        e.preventDefault();
        var form_data = $(this).serialize(); // Собираем все данные из формы
        //console.log(form_data);
        form_data += "&data=1";
        $.ajax({
            type: "POST", // Метод отправки
            url: "/admin/index.php", // Путь до php файла отправителя
            data: form_data,
            success: function(a) {
                console.log(a);
                // Код в этом блоке выполняется при успешной отправке сообщения
                // alert("Ваше сообщение отправлено!");
            }
        });

    });
    var igeneral = -1;

    function clearinput() {

        var textarea = document.getElementById("words");
        textarea.value = "";

        igeneral = -1;

    }

    function nextWord(a) {
        /*  if (igeneral > 0) {
              var submit = document.getElementById("submit");
              if (a) {
                  submit.click()
              }
          }*/
        var text;
        var typeValue = document.querySelector("input[name=type]:checked").value;

        var textarea = document.getElementById("words");
        var word = document.getElementById("word");

        if (typeValue != 4 && typeValue != 3 && typeValue != 2) {
            text = textarea.value.replaceAll("\n\n", "").replaceAll("1)", "")
                .replaceAll("2)", "").replaceAll("3)", "").replaceAll("4)", "").replaceAll("5)", "").
            replace(" ", "").replaceAll("  ", "").replaceAll(" ", "").replaceAll("  ", ",").replaceAll("1.", "")
                .replaceAll("2.", "").replaceAll("3.", "").replaceAll("4.", "").replaceAll("5.", "")
                .replaceAll(".", "").replaceAll(";", ",") //.
                /*
                replaceAll("А","А").replaceAll("О","О")
                .replaceAll("И","И").replaceAll("З","З")
                .replaceAll("С","С").replaceAll("Д","Д")
                .replaceAll("Т","Т").replaceAll("Е","Е")
                .replaceAll("Ь","Ь").replaceAll("Ъ","Ъ")
                .replaceAll("Ы","Ы")
                */
                //.replaceAll("","")
                //.replaceAll("","").replaceAll("","")

                .split(",")
        }



        if (typeValue == 4) {
            text = textarea.value.replaceAll("\n", ",").split(",");


        }


        if (typeValue == 3 || typeValue == 2 || typeValue == 7) {
            text = textarea.value.split("\n");

        }




        if (text.length == 0) return;

        //words.value = text.join(" ")
        if (igeneral > 0) {
            var submit = document.getElementById("submit");
            if (a) {
                submit.click()
            }
        }



        if (igeneral < 0 || text[igeneral].length <= 2) {
            igeneral++;
            nextWord(false);
            return;
        }


        if (typeValue == 4) {

            var wordAccept = document.getElementById("wordAccept");
            var answerInput = document.getElementById("answer");
            var someWord = document.getElementById("someWord");
            var fastanswer = document.getElementById("fastanswer")

            wordAccept.value = text[igeneral]
            answerInput.value = text[igeneral]
            someWord.value = text[igeneral]
            fastanswer.value = text[igeneral]

            var letters = document.getElementById("letter");
            letters.value = "дн";
        }



        if (typeValue == 3) {
            var wordAccept = document.getElementById("wordAccept");
            var answerInput = document.getElementById("answer");
            var someWord = document.getElementById("someWord");
            var fastanswer = document.getElementById("fastanswer")

            wordAccept.value = text[igeneral].split(",")[0].split(" ")[0].toLowerCase()
            answerInput.value = text[igeneral].split(",")[0].split(" ")[0]
            someWord.value = text[igeneral].split(",")[0].split(" ")[0].toLowerCase()
            fastanswer.value = text[igeneral].split(",")[0].split(" ")[0]
            var letters = document.getElementById("letter");
            letters.value = "NaN";
        }



        word.value = text[igeneral];




        updateInput(text[igeneral], typeValue);


        if (typeValue == 3) {
            word.value = text[igeneral].split(",")[0].split(" ")[0].toLowerCase();
            updateInput(text[igeneral].split(",")[0].split(" ")[0], typeValue);

        }

        igeneral++;
        if (igeneral >= text.length) {
            igeneral = text.length - 1;
            clearinput();
        }
        var word = document.getElementById("word");




        $.ajax({
            type: "POST", // Метод отправки
            url: "/admin/index.php", // Путь до php файла отправителя
            data: "data=2&word=" + word.value.toLowerCase() + "&type=" + typeValue,
            success: function(g) {
                //--------------------
                if (Number(g) != 0) {
                    nextWord(false);
                }
                //--------------------
            }
        });


    }
</script>


<?php



include_once "../include/ender/tend.php";
?>