<?php

include "../backend/controller.php";

getAchievement($_GET['id']);

header('Location: ../game.php?id='.$_GET['game_id']);
