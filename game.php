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
                    <img src="<?=$bannerSrc?>" style='max-height:800px; max-width:1000px; height:auto; width:auto;'>
                  <h1 class="display-4 fw-bold ls-sm"><?=$game_info['name']?></h1>
                  <div class="d-lg-flex align-items-center mt-4">
                    <div>
                      <p class="mb-lg-0"><?=$game_info['description']?></p>
                    </div>
                  </div>

                </div>
                <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
                  <!-- card -->
                  <div class="card">
                    <!-- card body -->
                    <div class="card-body p-6 border-bottom mb-4">
                      <!-- text -->
                      <h2 class="mb-3">Buy game</h2>
                      <p class="mb-0">Add this game to your collection!</p>
                      <!-- price -->
                      <div class="d-flex align-items-end mt-6 mb-3">
                        <h1 class="fw-bold me-1 mb-0"><?=$game_info['price']?></h1>
                      </div>
                      <!-- button -->
                        <?php if(!ownsGame($_GET['id'])) { ?>
                            <a href="./services/buy-game.php?game_id=<?=$_GET['id']?>" class="btn btn-primary">Buy Game</a>
                        <?php } else { ?>
                            <button class="btn btn-outline-primary">Owned</button>
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
                      <p class="mb-0">This game has the following DLCs:</p>
                        <div>&nbsp;</div>
                        <?php
                            foreach ($game_dlc AS $dlc)
                            {
                        ?>
                              <div class="row" style="padding-bottom: 10px;">
                                  <div class="col-sm"><h4 class="fw-bold me-1 mb-0"><?=$dlc['name']?> (<?=$dlc['price']?>)</h4></div>
                                  <div class="col-sm text-end float-end">
                                      <?php if(!ownsGame($_GET['id'])) { ?>
                                          <button class="btn btn-sm btn-outline-primary">Game not owned</button>
                                      <?php } else if(!ownsDlc($dlc['id'])) { ?>
                                          <a href="./services/buy-dlc.php?game_id=<?=$_GET['id']?>&id=<?=$dlc['id']?>" class="btn btn-sm btn-primary">Buy DLC</a>
                                      <?php } else { ?>
                                          <button class="btn btn-sm btn-outline-primary">Owned</button>
                                      <?php } ?>
                                  </div>
                              </div>
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
                      <p class="mb-0">Go after the highest score with these achievements:
                        <div>&nbsp;</div>
                        <?php
                        foreach ($game_achi AS $achievement)
                        {
                            ?>
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-sm"><h6 class="fw-bold me-1 mb-0"><?=$achievement['name']?> (<?=$achievement['score']?>)</h6></div>
                                <div class="col-sm text-end float-end">
                                    <?php if(!ownsGame($_GET['id'])) { ?>
                                        <button class="btn btn-sm btn-outline-primary">Game not owned</button>
                                    <?php } else if(!ownsAchievement($achievement['id'])) { ?>
                                        <a href="./services/get-achievement.php?game_id=<?=$_GET['id']?>&id=<?=$achievement['id']?>" class="btn btn-sm btn-primary">Get</a>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-outline-primary">Earned</button>
                                    <?php } ?>
                                </div>
                            </div>
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
