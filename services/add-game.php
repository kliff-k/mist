<?php

include "../backend/controller.php";

$banner = file_get_contents($_FILES['userfile']['tmp_name'])?:null;

registerGame($_POST['name'], $_POST['description'], $_POST['price'], $banner);

header('Location: ../admin.php');
