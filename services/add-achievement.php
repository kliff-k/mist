<?php

include "../backend/controller.php";

includeAchievement($_GET['id'], $_POST['name'], $_POST['score']);

header('Location: ../details.php?id='.$_GET['id']);
