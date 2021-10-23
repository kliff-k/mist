<?php

include "../backend/controller.php";

removeDlc($_GET['dlc_id']);

header('Location: ../details.php?id='.$_GET['id']);
