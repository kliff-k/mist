<?php

include "../backend/controller.php";

$avatar = file_get_contents($_FILES['userfile']['tmp_name'])?:null;

if (isLoggedIn())
{
    updateAvatar($avatar);
    $_SESSION['auth_avatar'] = $avatar;
}

header('Location: ../profile.php');
