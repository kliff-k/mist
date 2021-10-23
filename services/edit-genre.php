<?php

include "../backend/controller.php";

editGenre($_GET['id'], $_POST['name']);

header('Location: ../genres.php');
