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
    <!-- Page content -->
    <div id="page-content">
        <!-- navbar -->
        <?php include './components/navbar.php'; ?>
        <!-- Container fluid -->
        <div class="bg-primary pt-10 pb-21"></div>
        <div class="container-fluid mt-n22 px-6">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Page header -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-2 mb-lg-0">
                                <h3 class="mb-0 fw-bold text-white">Overview</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                    <!-- card -->
                    <div class="card rounded-3">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Games</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                    <i class="bi bi-controller fs-4"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div>
                                <h1 class="fw-bold"><?=gameCount()?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                    <!-- card -->
                    <div class="card rounded-3">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">DLC</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                    <i class="bi bi-clipboard-plus fs-4"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div>
                                <h1 class="fw-bold"><?=dlcCount()?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                    <!-- card -->
                    <div class="card rounded-3">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Achievements</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                    <i class="bi bi-trophy fs-4"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div>
                                <h1 class="fw-bold"><?=achievementCount()?></h1>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                    <!-- card -->
                    <div class="card rounded-3">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- heading -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-0">Players</h4>
                                </div>
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                            </div>
                            <!-- project number -->
                            <div>
                                <h1 class="fw-bold"><?=playerCount()?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row  -->
            <div class="row mt-6">
                <div class="col-md-12 col-12">
                    <!-- card  -->
                    <div class="card">
                        <!-- card header  -->
                        <div class="card-header bg-white border-bottom-0 py-4">
                            <h4 class="mb-0">Most popular games</h4>
                        </div>
                        <!-- table  -->
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>Game</th>
                                    <th>Players</th>
                                    <th>Genre</th>
                                    <th>DLCs</th>
                                    <th>Achievements</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $rows = landingGames();
                                    foreach ($rows AS $row)
                                    {
                                        if($row['banner'])
                                            $bannerSrc = "data:image/*;base64," . base64_encode(stream_get_contents($row['banner']));
                                        else
                                            $bannerSrc = "./assets/images/icons/controller.png";
                                ?>
                                    <tr>
                                        <td class="align-middle"><div class="d-flex align-items-center">
                                                <div>
                                                    <div class="icon-shape icon-md border p-4 rounded-1">
                                                        <img width="24" height="23" src="<?=$bannerSrc?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="ms-3 lh-1">
                                                    <h5 class="fw-bold mb-1"> <a href="game.php?id=<?=$row['id']?>" class="text-inherit"><?=$row['name']?></a></h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle"><?=$row['players']?></td>
                                        <td class="align-middle"><?=$row['game_genre']?></td>
                                        <td class="align-middle"><?=$row['dlcs']?></td>
                                        <td class="align-middle"><?=$row['achievements']?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <!-- card footer  -->
                            <div class="card-footer bg-white text-center">
                                <a href="store.php">See all games </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- row  -->
            <div class="row my-6">
                <!-- card  -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="card h-100">
                        <!-- card header  -->
                        <div class="card-header bg-white border-bottom-0 py-4">
                            <h4 class="mb-0">Newest Players</h4>
                        </div>
                        <!-- table  -->
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Games owned</th>
                                    <th>Achievements</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $rows = landingPlayers();
                                    foreach ($rows AS $row)
                                    {
                                        if($row['avatar'])
                                            $avatarSrc = "data:image/*;base64," . base64_encode(stream_get_contents($row['avatar']));
                                        else
                                            $avatarSrc = "./assets/images/icons/avatar.jpg";
                                ?>
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <img width="40" height="40" src="<?=$avatarSrc?>" alt="" class="avatar-md avatar rounded-circle">
                                                </div>
                                                <div class="ms-3 lh-1">
                                                    <h5 class="fw-bold mb-1"> <a href="./player.php?id=<?=$row['id']?>" class="text-inherit"><?=$row['nickname']?></a></h5>
                                                    <p class="mb-0"><?=$row['birthday']?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle"><?=$row['games']?></td>
                                        <td class="align-middle"><?=$row['achievements']?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <!-- card footer  -->
                            <div class="card-footer bg-white text-center">
                                <a href="community.php">See all players</a>
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
