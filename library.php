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
              <div class="border-bottom pb-4 mb-4 ">
                <div class="mb-2 mb-lg-0">
                  <h3 class="mb-0 fw-bold">Profile</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <!-- Bg -->
            <div class="pt-20 rounded-top" style="background: url(./assets/images/background/profile-cover.jpg) no-repeat; background-size: cover;">
            </div>
            <div class="bg-white rounded-bottom smooth-shadow-sm ">
              <div class="d-flex align-items-center justify-content-between
                  pt-4 pb-6 px-4">
                <div class="d-flex align-items-center">
                  <!-- avatar -->
                  <div class="avatar-xxl avatar-indicators avatar-online me-2
                      position-relative d-flex justify-content-end
                      align-items-end mt-n10">
                      <?php

                      $player = getPlayerInfo($_GET['id']);

                      if($player['avatar'])
                          $avatarSrc = "data:image/*;base64," . base64_encode(stream_get_contents($player['avatar']));
                      else
                          $avatarSrc = "./assets/images/icons/avatar.jpg";
                      ?>
                    <img src="<?=$avatarSrc?>" class="avatar-xxl rounded-circle border border-4 border-white-color-40" alt="">
                  </div>
                  <!-- text -->
                  <div class="lh-1">
                    <h2 class="mb-0"><?=$player['nickname']?>
                      <a href="#!" class="text-decoration-none" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Beginner">
                      </a>
                    </h2>
                    <p class="mb-0 d-block">@<?=$player['name']?></p>
                  </div>
                </div>
                <div>
                    <?php
                        if($_GET['id'] == $_SESSION['auth_id'])
                            $friend_button = '';
                        else if(isFriend($_GET['id']))
                            $friend_button = '<a href="services/toggle-friend.php?id='.$_GET['id'].'" class="btn btn-outline-danger d-none d-md-block">Remove friend</a>';
                        else
                            $friend_button = '<a href="services/toggle-friend.php?id='.$_GET['id'].'" class="btn btn-outline-primary d-none d-md-block">Add friend</a>';

                        echo $friend_button;
                    ?>
                </div>
              </div>
              <!-- nav -->
              <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="player.php?id=<?=$_GET['id']?>">Overview</a>
                </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="library.php?id=<?=$_GET['id']?>">Games</a>
                  </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- content -->
        <div class="py-6">
          <!-- row -->
          <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-4">
              <!-- card -->
              <div class="card">
                <!-- card body -->
                <div class="card-body">
                  <!-- card title -->
                  <h4 class="card-title mb-4">Games</h4>
                  <!-- row -->
                    <?php
                    $rows = getPlayerLibrary($_GET['id']);
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
                        </tr>
                    <?php } ?>
                </div>
              </div>
            </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-4">
                    <!-- card -->
                    <div class="card">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- card title -->
                            <h4 class="card-title mb-4">DLCs</h4>
                            <!-- row -->
                            <?php
                            $rows = getPlayerDlcs($_GET['id']);
                            foreach ($rows AS $row)
                            {
                                if($row['banner'])
                                    $bannerSrc = "data:image/*;base64," . base64_encode(stream_get_contents($row['banner']));
                                else
                                    $bannerSrc = "./assets/images/icons/dlc.png";
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
                                </tr>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-4">
                    <!-- card -->
                    <div class="card">
                        <!-- card body -->
                        <div class="card-body">
                            <!-- card title -->
                            <h4 class="card-title mb-4">Achievements</h4>
                            <!-- row -->
                            <?php
                            $rows = getPlayerAchievements($_GET['id']);
                            foreach ($rows AS $row)
                            {
                                if($row['banner'])
                                    $bannerSrc = "data:image/*;base64," . base64_encode(stream_get_contents($row['banner']));
                                else
                                    $bannerSrc = "./assets/images/icons/trophy.png";
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
  <?php include "./components/scripts.php"; ?>
</body>

</html>
