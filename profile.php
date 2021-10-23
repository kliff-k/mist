<?php

include "./backend/controller.php";

if(!isLoggedIn())
    header('Location: index.php');

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
      <div class="container-fluid px-6 py-4">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
              <div class="border-bottom pb-4 mb-4 d-flex align-items-center
                  justify-content-between">
                <div class="mb-2 mb-lg-0">
                  <h3 class="mb-0 fw-bold">General</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-8">
          <div class="col-xl-3 col-lg-4 col-md-12 col-12">
            <div class="mb-4 mb-lg-0">
              <h4 class="mb-1">General Setting</h4>
              <p class="mb-0 fs-5 text-muted">Profile configuration settings </p>
            </div>

          </div>

          <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <!-- card -->
            <div class="card">
              <!-- card body -->
              <div class="card-body">
                <div class=" mb-6">
                  <h4 class="mb-1">General Settings</h4>

                </div>
                <div class="row align-items-center mb-8">
                  <div class="col-md-3 mb-3 mb-md-0">
                    <h5 class="mb-0">Avatar</h5>
                  </div>
                  <div class="col-md-9">
                    <div class="d-flex align-items-center">
                      <div class="me-3">
                          <?php
                          if($_SESSION['auth_avatar'])
                              $avatarSrc = "data:image/*;base64," . base64_encode($_SESSION['auth_avatar']);
                          else
                              $avatarSrc = "./assets/images/icons/avatar.jpg";
                          ?>
                        <img src="<?=$avatarSrc?>" class="rounded-circle avatar avatar-lg" alt="">
                      </div>
                      <div>
                          <form action="services/clear.php" method="post" onsubmit="confirmDeleteAvatar()">
                              <button type="submit" class="btn btn-outline-white">Remove</button>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- col -->
                <div class="row mb-8">
                  <div class="col-md-3 mb-3 mb-md-0">
                    <!-- heading -->
                  </div>
                  <div class="col-md-9">
                    <div>
                        <form enctype="multipart/form-data" action="services/avatar.php" method="POST">
                            <input name="userfile" type="file" required/>
                            <button type="submit" class="btn btn-outline-white">Change</button>
                        </form>
                    </div>
                  </div>
                </div>
                <div>
                  <!-- border -->
                  <div class="mb-6">
                    <h4 class="mb-1">Basic information</h4>

                  </div>
                  <form action="services/update.php" method="post">
                    <!-- row -->
                    <div class="mb-3 row">
                      <label for="fullName" class="col-sm-4 col-form-label form-label">Nickname</label>
                      <div class="col-sm-4 mb-3 mb-lg-0">
                        <input type="text" class="form-control" placeholder="Nickname" id="nickname" name="nickname" value="<?=$_SESSION['auth_nickname']?>" required>
                      </div>
                    </div>
                    <!-- row -->
                    <div class="mb-3 row">
                      <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                      <div class="col-md-4 col-12">
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="<?=$_SESSION['auth_email']?>" required>
                      </div>
                    </div>
                    <!-- row -->
                    <div class="mb-3 row">
                      <label for="phone" class="col-sm-4 col-form-label form-label">Birthday <span class="text-muted">(Optional)</span></label>
                      <div class="col-md-8 col-12">
                        <input type="date" class="form-control" placeholder="Birthday" id="birthday" name="birthday" value="<?=$_SESSION['auth_birthday']?>">
                      </div>
                    </div>
                      <div class="offset-md-4 col-md-8 mt-4">
                        <button type="submit" class="btn btn-primary"> Save Changes</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-xl-3 col-lg-4 col-md-12 col-12">
            <div class="mb-4 mb-lg-0">
              <h4 class="mb-1">Delete Account</h4>
              <p class="mb-0 fs-5 text-muted">Easily terminate your account</p>
            </div>

          </div>

          <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <!-- card -->

            <div class="card mb-6">
              <!-- card body -->
              <div class="card-body">
                <div class="mb-6">
                  <h4 class="mb-1">Danger Zone </h4>

                </div>
                <div>
                  <!-- text -->
                  <p>Delete any and all content you have, such as games, posts and achievements. Allow your username to become available to anyone.</p>
                    <form action="services/terminate.php" method="post" onsubmit="confirmDeleteAccount()">
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </form>
                  <p class="small mb-0 mt-3">Feel free to contact with any <a href="#">support@mist.com</a> questions.
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

<?php include "./components/scripts.php"; ?>

<script>
    function confirmDeleteAccount()
    {
        if (!confirm("Are you sure you want to delete your account?"))
        {
            event.preventDefault();
        }
    }
    function confirmDeleteAvatar()
    {
        if (!confirm("Are you sure you want to delete your avatar?"))
        {
            event.preventDefault();
        }
    }
</script>

</body>

</html>
