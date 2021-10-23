<?php

include "../backend/controller.php";

deleteGame($_GET['id']);

header('Location: ../admin.php');
