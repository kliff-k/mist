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
    <!-- navbar vertical  -->
     <!-- Sidebar -->
      <?php include './components/sidebar.php'; ?>
    <!-- page content  -->
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
                  <h3 class="mb-0 fw-bold">Admin panel</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- row  -->
        <div class="row mt-6">
          <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 col-md-12 col-12">
            <div class="row">
              <div class="col-12 mb-6">
                <!-- card  -->
                <div class="card">
                  <!-- card header  -->
                  <div class="card-header p-4 bg-white">
                    <h4 class="mb-0">Add game</h4>
                  </div>
                  <!-- card body  -->
                    <form enctype="multipart/form-data" action="./services/add-game.php" method="POST">
                  <div class="card-body">
                    <!-- row  -->
                    <div class="row">
                      <div class="col-xl-8 col-lg-6 col-md-12 col-12">
                        <div class="mb-2">
                                <label for="name" class="form-label">Title</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Title" required="">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" id="description" class="form-control" name="description" placeholder="Description" required="">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" id="price" class="form-control" name="price" placeholder="Price" required="">
                                <label for="username" class="form-label">Banner</label><br>
                                <input name="userfile" type="file"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- card footer  -->
                  <div class="card-footer bg-white">
                    <div class="d-md-flex justify-content-between align-items-center text-end float-end">
                      <div class="text-center text-md-start">
                        <button type="submit" class="btn btn-primary ms-2" style="margin-bottom: 10px;">Add</button>
                      </div>
                    </div>
                  </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>

          <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 col-md-12 col-12">
              <div class="row">
                  <div class="col-12 mb-6">
                      <!-- card  -->
                      <div class="card">
                        <div class="table-responsive">
              <table class="table">
                  <thead >
                  <tr>
                      <th scope="col">Game</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $rows = gameList($_GET['search']);
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
                                      <h5 class="fw-bold mb-1"> <a href="details.php?id=<?=$row['id']?>" class="text-inherit"><?=$row['name']?></a></h5>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  <?php } ?>
                  </tbody>
              </table>
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
