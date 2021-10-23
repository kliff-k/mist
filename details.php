<?php

include "./backend/controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "./components/head.php"; ?>
</head>

<body>
<div id="db-wrapper">
    <!-- navbar vertical -->
    <!-- Sidebar -->
    <?php include './components/sidebar.php'; ?>
    <!-- page content -->
    <div id="page-content">
        <!-- navbar -->
        <?php include './components/navbar.php'; ?>
        <!-- Container fluid -->
        <div class="container-fluid px-6 py-4">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Page header -->
                    <div class="border-bottom pb-4 mb-4">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0 fw-bold">Game Page</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content -->
            <?php

            $game_info = getGameInfo($_GET['id']);
            $game_dlc  = getGameDlc($_GET['id']);
            $game_achi = getGameAchievement($_GET['id']);

            ?>
            <div class="py-8">
                <div class="row">
                    <!-- col -->
                    <div class="offset-xl-1 col-xl-10 col-md-12">
                        <div class="row mb-10">
                            <!-- text -->
                            <div class="col-md-12 col-12 mb-8">

                                <?php

                                if($game_info['banner'])
                                    $bannerSrc = "data:image/*;base64," . base64_encode(stream_get_contents($game_info['banner']));
                                else
                                    $bannerSrc = "./assets/images/background/profile-cover.jpg";
                                ?>
                                <h1 class="display-4 fw-bold ls-sm"><?=$game_info['name']?></h1>
                                <div class="d-lg-flex align-items-center mt-4">
                                    <form enctype="multipart/form-data" action="./services/edit-game.php?id=<?=$_GET['id']?>" method="post">
                                        <input id="name" name="name" type="text" value="<?=$game_info['name']?>">
                                        <input style="width: 80px;" id="price" name="price" type="number" value="<?=$game_info['price']?>">
                                        <input style="width: 300px;" id="description" name="description" type="text" value="<?=$game_info['description']?>">
                                        <input name="userfile" type="file"/>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                    </form>
                                    &nbsp;
                                    <form action="./services/delete-game.php?id=<?=$_GET['id']?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>

                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body p-6 border-bottom mb-4">
                                        <!-- text -->
                                        <h2 class="mb-3">Genres</h2>
                                        <form action="./services/include-genre.php?id=<?=$_GET['id']?>" method="post">
                                            <select style="width: 210px;" name="genre_id" id="genre_id">
                                            <?php
                                            $rows = inverseGameGenreList($_GET['id']);
                                            foreach ($rows AS $row)
                                            {
                                                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                            }
                                            ?>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-outline-success">Add</button>
                                        </form>
                                        <div>&nbsp;</div>
                                        <?php
                                        $rows = gameGenreList($_GET['id']);
                                        foreach ($rows AS $row)
                                        {
                                            ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <form action="#" method="post">
                                                            <input readonly="true" id="name" name="name" type="text" value="<?=$row['name']?>">
                                                        </form>
                                                        &nbsp;
                                                        <form action="./services/remove-genre.php?genre_id=<?=$row['id']?>&id=<?=$_GET['id']?>" method="post">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body p-6 border-bottom mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div>
                                                <!-- title -->
                                                <h2 class="mb-0">DLCs</h2>
                                            </div>
                                        </div>
                                        <!-- text -->
                                        <form action="./services/add-dlc.php?id=<?=$_GET['id']?>" method="post">
                                            <input style="width: 170px;" id="name" name="name" type="text" placeholder="Name">
                                            <input style="width: 60px;" id="price" name="price" type="number" placeholder="Price">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Add</button>
                                        </form>
                                        <div>&nbsp;</div>
                                        <?php
                                        foreach ($game_dlc AS $dlc)
                                        {
                                            ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <form action="./services/edit-dlc.php?id=<?=$_GET['id']?>&dlc_id=<?=$dlc['id']?>" method="post">
                                                            <input style="width: 170px;" id="name" name="name" type="text" value="<?=$dlc['name']?>">
                                                            <input style="width: 60px;" id="price" name="price" type="number" value="<?=$dlc['price']?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                                        </form>
                                                        &nbsp;
                                                        <form action="./services/remove-dlc.php?id=<?=$_GET['id']?>&dlc_id=<?=$dlc['id']?>" method="post">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body p-6 border-bottom mb-4">
                                        <h2 class="mb-3">Achievements</h2>
                                        <form action="./services/add-achievement.php?id=<?=$_GET['id']?>" method="post">
                                            <input style="width: 190px;" id="name" name="name" type="text" placeholder="Name">
                                            <input style="width: 70px;" id="score" name="score" type="number" placeholder="Score">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Add</button>
                                        </form>
                                        <div>&nbsp;</div>
                                        <?php
                                        foreach ($game_achi AS $achievement)
                                        {
                                            ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <form action="./services/edit-achievement.php?id=<?=$_GET['id']?>&ac_id=<?=$achievement['id']?>" method="post">
                                                            <input style="width: 190px;" id="name" name="name" type="text" value="<?=$achievement['name']?>">
                                                            <input style="width: 40px;" id="score" name="score" type="number" value="<?=$achievement['score']?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                                        </form>
                                                        &nbsp;
                                                        <form action="./services/remove-achievement.php?id=<?=$_GET['id']?>&ac_id=<?=$achievement['id']?>" method="post">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "./components/scripts.php"; ?>
</body>

</html>
