<?php

include "../backend/controller.php";

$content    = $_POST['comment'];
$screenshot = file_get_contents($_FILES['userfile']['tmp_name'])?:null;

if (isLoggedIn())
{
    post($_GET['user'], $content, $screenshot);
}

header('Location: ../player.php?id='.$_GET['user']);
