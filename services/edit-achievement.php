<?php

include "../backend/controller.php";

editAchievement($_GET['ac_id'], $_POST['name'], $_POST['score']);

header('Location: ../details.php?id='.$_GET['id']);
