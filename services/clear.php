<?php

include "../backend/controller.php";

if (isLoggedIn())
{
    deleteAvatar();
    $_SESSION['auth_avatar'] = "";
}

header('Location: ../profile.php');
