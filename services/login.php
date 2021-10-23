<?php

include "../backend/controller.php";

$res = loginUser($_POST['username'], $_POST['password']);

if($res)
    header('Location: ../index.php');
else
    header('Location: ../sign-in.php');
