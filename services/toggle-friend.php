<?php

include "../backend/controller.php";

toggleFriend($_GET['id']);

header('Location: ../player.php?id='.$_GET['id']);
