<?php

include "../backend/controller.php";

removeGenre($_GET['id'], $_GET['genre_id']);

header('Location: ../details.php?id='.$_GET['id']);
