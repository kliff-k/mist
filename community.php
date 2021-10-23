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
                    <div>
                        <div class="border-bottom pb-4">
                            <div class="mb-2 mb-lg-0">
                                <h3 class="mb-0 fw-bold">Community</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-6">
                <!-- table -->
                <div class="row mb-6">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div id="examples" class="mb-4">
                            <h2>Players</h2>
                        </div>
                        <!-- Card -->
                        <div class="card">
                            <!-- Tab content -->
                            <div class="tab-content p-4" id="pills-tabContent-table">
                                <div class="tab-pane tab-example-design fade show active" id="pills-table-design" role="tabpanel" aria-labelledby="pills-table-design-tab">
                                    <!-- Basic table -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead >
                                            <tr>
                                                <th scope="col">Player</th>
                                                <th scope="col">Games Owned</th>
                                                <th scope="col">Achievements</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $rows = playerList($_GET['search']);
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
                                    </div>
                                    <!-- Basic table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- table -->
            </div>
        </div>
    </div>
</div>

<?php include "./components/scripts.php"; ?>
</body>

</html>
