<?php

function setTitle($text){

echo '<script>  browser.browserAction.setTitle({ title: "'.$text.'" }); </script>';

}


?>