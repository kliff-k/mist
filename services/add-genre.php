<?php

include "../backend/controller.php";

addGenre($_POST['name']);

header('Location: ../genres.php');
