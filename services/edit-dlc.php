<?php

include "../backend/controller.php";

editDlc($_GET['dlc_id'], $_POST['name'], $_POST['price']);

header('Location: ../details.php?id='.$_GET['id']);
