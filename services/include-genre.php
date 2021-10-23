<?php

include "../backend/controller.php";

includeGenre($_GET['id'], $_POST['genre_id']);

header('Location: ../details.php?id='.$_GET['id']);
