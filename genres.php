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
                    <h4 class="mb-0">Add genre</h4>
                  </div>
                  <!-- card body  -->
                    <form action="./services/add-genre.php" method="POST">
                  <div class="card-body">
                    <!-- row  -->
                    <div class="row">
                      <div class="col-xl-8 col-lg-6 col-md-12 col-12">
                        <div class="mb-2">
                                <label for="name" class="form-label">Genre</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Genre" required="">
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
                  $rows = genreList();
                  foreach ($rows AS $row)
                  {
                      ?>
                      <tr>
                          <td class="align-middle">
                              <div class="d-flex align-items-center">
                                      <form action="./services/edit-genre.php?id=<?=$row['id']?>" method="post">
                                              <input id="name" name="name" type="text" value="<?=$row['name']?>">
                                              <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                      </form>
                                  &nbsp;
                                        <form action="./services/delete-genre.php?id=<?=$row['id']?>" method="post">
                                              <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
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
