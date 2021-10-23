<?php

include "../backend/controller.php";

buyDlc($_GET['id']);

header('Location: ../game.php?id='.$_GET['game_id']);
