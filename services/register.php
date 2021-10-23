<?php

include "../backend/controller.php";

registerUser($_POST['username'], $_POST['nickname'], $_POST['password'], $_POST['email']);

header('Location: ../admin.php');
