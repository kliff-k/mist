<?php

include "../backend/controller.php";

if (isLoggedIn())
{
    deletePost($_GET['post']);
}

header('Location: ../player.php?id='.$_GET['user']);
