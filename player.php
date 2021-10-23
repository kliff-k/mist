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
                    <a class="nav-link active" href="player.php?id=<?=$_GET['id']?>">Overview</a>
                </li>
                  <li class="nav-item">
                      <a class="nav-link" href="library.php?id=<?=$_GET['id']?>">Games</a>
                  </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- content -->
        <div class="py-6">
          <!-- row -->
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-6">
              <!-- card -->
              <div class="card">
                <!-- card body -->
                <div class="card-body">
                  <!-- card title -->
                  <h4 class="card-title mb-4">Info</h4>
                  <!-- row -->
                  <div class="row">
                    <div class="col-4">
                      <h6 class="text-uppercase fs-5 ls-2">Email </h6>
                      <p class="mb-0"><?=$player['email']?></p>
                    </div>
                    <div class="col-4">
                      <h6 class="text-uppercase fs-5 ls-2">Birthday</h6>
                      <p class="mb-0"><?=$player['birthday']?></p>
                    </div>
                      <div class="col-4">
                          <h6 class="text-uppercase fs-5 ls-2">Member since</h6>
                          <p class="mb-0"><?=date('Y-m-d H:i:s',strtotime($player['created']));?></p>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-12 col-md-12 col-12 mb-12">
              <!-- card -->
              <div class="card">
                <!-- card body -->
                <div class="card-body">
                    <?php
                        $posts = getFeed($_GET['id']);

                        foreach ($posts AS $post)
                        {

                            if($post['avatar'])
                                $avatarSrc = "data:image/*;base64," . base64_encode(stream_get_contents($post['avatar']));
                            else
                                $avatarSrc = "./assets/images/icons/avatar.jpg";

                            if($post['screenshot'])
                                $screenshot = "<img src='data:image/*;base64," . base64_encode(stream_get_contents($post['screenshot'])) . "' class='rounded-3 w-100' alt='' style='max-height:800px; max-width:800px; height:auto; width:auto;'>";
                            else
                                $screenshot = "";

                    ?>
                  <div class="d-flex justify-content-between mb-5 align-items-center">
                    <!-- avatar -->
                    <div class="d-flex align-items-center">
                      <div>
                        <img src="<?=$avatarSrc?>" alt="" class="avatar avatar-md rounded-circle">
                      </div>
                      <div class="ms-3">
                        <h5 class="mb-0 fw-bold"><?=$post['nickname']?></h5>
                        <p class="mb-0"><?=date('Y-m-d H:i:s',strtotime($post['datetime']));?></p>
                      </div>
                    </div>
                    <div>
                        <?php
                            if($post['poster_id'] == $_SESSION['auth_id'] OR $post['player_id'] == $_SESSION['auth_id'])
                            {
                        ?>
                      <!-- dropdown -->
                      <div class="dropdown dropstart">
                        <a href="#" class="text-muted text-primary-hover" id="dropdownprojectFive" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i data-feather="more-vertical" class="icon-xxs"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownprojectFive">
                          <a class="dropdown-item" href="services/delete-post.php?post=<?=$post['id']?>&user=<?=$_GET['id']?>">Delete</a>
                        </div>
                      </div>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="mb-4">
                      <?=$screenshot?>
                      <p class="mb-4"><?=$post['content']?></p>
                  </div>

                    <?php } ?>

                  <!-- row -->
                  <div class="row">
                    <div class="col-xl-1 col-lg-2 col-md-2 col-12 mb-3 mb-lg-0">
                      <!-- avatar -->

                        <?php
                        if($_SESSION['auth_avatar'])
                            $avatarSrc = "data:image/*;base64," . base64_encode($_SESSION['auth_avatar']);
                        else
                            $avatarSrc = "./assets/images/icons/avatar.jpg";
                        ?>
                      <img src="<?=$avatarSrc?>" class="avatar avatar-md rounded-circle" alt="">
                    </div>
                    <!-- input -->
                    <div class="col-xl-11 col-lg-10 col-md-9 col-12 ">
                        <form enctype="multipart/form-data" action="services/post.php?user=<?=$_GET['id']?>" method="POST">
                          <div class="row g-3 align-items-center">
                            <div class="col-md-2 col-xxl-1">
                              <label for="comment" class="col-form-label ">Comment</label>
                            </div>
                            <div class="col-md-6 col-xxl-9  mt-0 mt-md-3">
                              <input type="text" id="comment" name="comment" class="form-control" aria-describedby="comment">
                            </div>
                            <div class="col-md-2 col-xxl-2">
                                <input name="userfile" type="file"/>
                            </div>
                          </div>
                            <div class="col-md-12 col-xxl-12">&nbsp;</div>
                            <div class="col-md-2 col-xxl-2 float-end">
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>

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
