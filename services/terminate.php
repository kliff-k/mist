<?php

include "../backend/controller.php";

if (isLoggedIn())
{
    deleteUser();
    session_start();
    session_destroy();
}

header('Location: ../index.php');
