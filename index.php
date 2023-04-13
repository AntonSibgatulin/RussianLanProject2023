<?php
include_once("include/user/user.php");
include_once("config/config.php");
include_once("database/database.php");




?>

<div class="flex-center pre-menu">
	<!--
<div class="flex-left">
	<input type="radio" name="styles" id="korni" checked value="0">
	<label for="korni">Корни</label>
</div>


<div class="flex-left">
	<input type="radio" name="styles" id="prist" value="1">
	<label for="prist">Приставки</label>
</div>


<div class="flex-left">
	<input type="radio" name="styles" id="suff" value="2">
	<label for="suff">Суффиксы</label>



<div class="flex-left">
	<input type="radio" name="styles" id="udar" value="3">
	<label for="udar">Ударения</label>
</div>


<div class="flex-left">
	<input type="radio" name="styles" id="err" value="4">
	<label for="err">Ошибки в слов.</label>
</div>


<div class="flex-left">
	<input type="radio" name="styles" id="error" value="5">
	<label for="error">Ошибки</label>
</div>
-->
	<form action="/train" method="GET">
		<div style="width: 100%;">
			<div class="text-virable">Выберите тип задания</div>
			<div class="flex-center">
				<select name="type" class="select-type" id="type_of_virable">
					<option value="1">Корни</option>
					<option value="2">Приставки</option>
					<option value="3">Суффиксы</option>
					<option value="4">Ударения</option>
					<option value="5">Словосочетания</option>
					<option value="6">Слитное написание слов</option>
					<option value="7">Исключить лишнее слово</option>
					<option value="8">Правописание суффиксов и окончаний глагольных форм </option>
				</select>width
			</div>
	


		<div class="flex-left" style="margin-top: 10px;">

			<div class="flex-left">
				<input type="radio" name="shuffle" id="shuffle" checked value="true">
				<label for="shuffle">В перемешку</label>
			</div>


			<div class="flex-left">
				<input type="radio" name="shuffle" id="shuffle1" value="false">
				<label for="shuffle1">Подряд</label>
			</div>

		</div>


		<div class="flex-left" style="margin-top: 10px;">
			Выберите кол-во слов
		</div>
		<div class="flex-left">
			<input type="range" value="30" id="count_word" name="count" step="1" min="0" max="346" style="width: 100%;">
			<p style="margin-top: 5px;">кол-во: <output id="value"></output></p>
		</div>



		<div class="flex-left" style="margin-top: 10px;">

			<div class="flex-left">
				<input type="radio" name="time" id="timeogr" checked value="true">
				<label for="timeogr">На время</label>
			</div>


			<div class="flex-left">
				<input type="radio" name="time" id="timeogr1" value="false">
				<label for="timeogr1">Без ограничения времени</label>
			</div>

		</div>


		<span id="time_window">
			<div class="flex-left" style="margin-top: 10px;">
				Выберите ограничение времени
			</div>
			<div class="flex-left">
				<input type="range" value="3" id="timeperiod" name="timeperiod" step="1" min="0" max="4" style="width: 100%;">
				<p style="margin-top: 5px;">ограничение: <output id="value_timeperiod"></output>сек.</p>
			</div>
		

		<div class="flex-left" style="margin-top:20px">

			<input style="width:100%;" type="submit" class="button" value="Начать" />
		</div>

	</form>



	<!--
	<div class="flex-left">
		<div class="menu-element">Корни</div>


		<div class="menu-items" id="menuItems0">


			<div class="flex-left item">
				<a href="/train/?type=0">Все слова</a>
			</div>



			<div class="flex-left item">
				<a href="/train/?type=0&shuffle=true">Случайные слова</a>
			</div>



			<div class="flex-left item">
				<a href="/train/?type=0&shuffle=true&time=true&timeperiod=0">Случайные слова с ограничением времени 5с на слово</a>
			</div>


			<div class="flex-left item">
				<a href="/train/?type=0&shuffle=true&time=true&timeperiod=1">Случайные слова с ограничением времени 3с на слово</a>
			</div>


			<div class="flex-left item">
				<a href="/train/?type=0&shuffle=true&time=true&timeperiod=2">Случайные слова с ограничением времени 2с на слово</a>
			</div>



			<div class="flex-left item">
				<a href="/train/?type=0&shuffle=true&time=true&timeperiod=3">Случайные слова с ограничением времени 1,5с на слово</a>
			</div>


			<div class="flex-left item">
				<a href="/train/?type=0&shuffle=true&time=true&timeperiod=4">Случайные слова с ограничением времени 1с на слово</a>
			</div>




		</div>



		<div class="menu-element">Приставки</div>

		<div class="menu-items" id="menuItems0">

			<div class="flex-left item">
				<a href="/train/?type=0">Все слова</a>
			</div>



			<div class="flex-left item">
				<a href="/train/?type=1&shuffle=true">Случайные слова</a>
			</div>



			<div class="flex-left item">
				<a href="/train/?type=1&shuffle=true&time=true&timeperiod=0">Случайные слова с ограничением времени 5с на слово</a>
			</div>


			<div class="flex-left item">
				<a href="/train/?type=1&shuffle=true&time=true&timeperiod=1">Случайные слова с ограничением времени 3с на слово</a>
			</div>


			<div class="flex-left item">
				<a href="/train/?type=1&shuffle=true&time=true&timeperiod=2">Случайные слова с ограничением времени 2с на слово</a>
			</div>



			<div class="flex-left item">
				<a href="/train/?type=1&shuffle=true&time=true&timeperiod=3">Случайные слова с ограничением времени 1,5с на слово</a>
			</div>


			<div class="flex-left item">
				<a href="/train/?type=1&shuffle=true&time=true&timeperiod=4">Случайные слова с ограничением времени 1с на слово</a>
			</div>




		</div>


	</div>

</div>
-->
	<!--

	<div class="flex-left" style="margin-top:20px">

		<a class="button" onclick="moveToPage()">Начать</a>

	</div>


-->
	<div class="flex-left" style="margin-top:20px">

		<a class="button" onclick="likeMoveToPage()">Избранное</a>

	</div>

	<script>
		const value = document.querySelector("#value")
		const input = document.querySelector("#count_word")
		value.textContent = input.value
		input.addEventListener("input", (event) => {
			value.textContent = event.target.value
		})






		const value1 = document.querySelector("#value_timeperiod")
		const input1 = document.querySelector("#timeperiod")
		value1.textContent = 1.5
		input1.addEventListener("input", (event) => {
			var time = event.target.value;
			if (Number(time) == 0) {
				time = 5;
			} else if (Number(time) == 1) {
				time = 3;
			} else if (Number(time) == 2) {
				time = 2;
			} else if (Number(time) == 3) {
				time = 1.5;
			} else if (Number(time) == 4) {
				time = 1;
			} else {
				time = 1.5;
			}
			value1.textContent = time;
		})


		setInterval(function() {
			var index = document.querySelector("input[name=time]:checked").value;
			var time_window = document.getElementById("time_window")
			if (index == "true") {
				time_window.style = "";
			} else {
				time_window.style = "display:none";
			}
			//console.log(index)
		}, 500
	</script>

