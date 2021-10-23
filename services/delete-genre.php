<?php

include "../backend/controller.php";

deleteGenre($_GET['id']);

header('Location: ../genres.php');
