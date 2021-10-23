<?php

include "../backend/controller.php";

$banner = file_get_contents($_FILES['userfile']['tmp_name'])?:null;

updateGame($_GET['id'], $_POST['name'], $_POST['description'], $_POST['price'], $banner);

header('Location: ../details.php?id='.$_GET['id']);
