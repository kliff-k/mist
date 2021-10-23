<?php

include "../backend/controller.php";

if (isLoggedIn())
{
    updateUser($_POST['nickname'], $_POST['email'], $_POST['birthday']?:null);
    $_SESSION['auth_email'] = $_POST['email'];
    $_SESSION['auth_birthday'] = $_POST['birthday'];
    $_SESSION['auth_nickname'] = $_POST['nickname'];
}

header('Location: ../profile.php');
