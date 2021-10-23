<?php

include "../backend/controller.php";

includeDlc($_GET['id'], $_POST['name'], $_POST['price']);

header('Location: ../details.php?id='.$_GET['id']);
