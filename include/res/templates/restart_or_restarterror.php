<div class="block-display">
    <div class="window-create">

        <div class="panel-close-window" id="main-panel-close-window" onclick="closeWindow(this)">

        </div>

        <div class="close-window" onclick="closeWindow(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <g id="close">
                    <path id="x" d="M18.717 6.697l-1.414-1.414-5.303 5.303-5.303-5.303-1.414 1.414 5.303 5.303-5.303 5.303 1.414 1.414 5.303-5.303 5.303 5.303 1.414-1.414-5.303-5.303z"></path>
                </g>
            </svg>
        </div>




        <div class="flex-center">

            <div class="text-header">
                Тест закончен!

            </div>

        </div>


        <div class="flex-center">
            <div class="text-virable" style="font-size: 20pt;">Кол-во правильных и не правильных слов</div>
        </div>

        <div class="flex-center">


            <div class="count_accept_and_unaccept" style="margin-top:5px;">
                <div class="accept" style="color: #080;">$accept</div>
                <div class="accept"> /</div>
                <div class="accept" style="color: #800;">$unaccept</div>
            </div>

        </div>


      
        <div class="flex-right">
        <a class="button-virable" onclick="initWordByType(null)">Сначала</a>
        <a class="button-virable" id="error_restart" style="margin-left:10px;" onclick="startErrorTest()">Разобрать ошибки</a>
        </div>

    </div>

</div>