<?php

include "../backend/controller.php";

removeAchievement($_GET['ac_id']);

header('Location: ../details.php?id='.$_GET['id']);
