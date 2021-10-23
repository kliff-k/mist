<?php

include "../backend/controller.php";

buyGame($_GET['game_id']);

header('Location: ../game.php?id='.$_GET['game_id']);
