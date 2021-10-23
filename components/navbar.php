<div class="header @@classList">
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
        <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
            <form action="<?=basename($_SERVER['PHP_SELF'], ".php")=='community'?'community':'store'?>.php" method="get" class="d-flex align-items-center">
                <input name="search" id="search" type="search" class="form-control" placeholder="Search" value="<?=$_GET['search']?>"/>
            </form>
        </div>
        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">

            <?php if(isLoggedIn()) { ?>

                <li class="dropdown stopevent">
                    <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted" href="#" role="button"
                       id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="icon-xs" data-feather="users"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                         aria-labelledby="dropdownNotification">
                        <div>
                            <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-dark fw-medium fs-4">Friends</p>
                            </div>
                            <!-- List group -->
                            <ul class="list-group list-group-flush notification-list-scroll">
                                <?php
                                $rows = friends();
                                foreach ($rows AS $row)
                                {
                                if($row['avatar'])
                                    $avatarSrc = "data:image/*;base64," . base64_encode(stream_get_contents($row['avatar']));
                                else
                                    $avatarSrc = "./assets/images/icons/avatar.jpg";
                                ?>
                                <!-- List group item -->
                                <li class="list-group-item bg-light">
                                    <img width="40" height="40" src="<?=$avatarSrc?>" alt="" class="avatar-md avatar rounded-circle">
                                    <a href="player.php?id=<?=$row['friend_id']?>" class="text-muted">
                                        <?=$row['nickname']?>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- List -->
                <li class="dropdown ms-2">
                    <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            <?php
                            if($_SESSION['auth_avatar'])
                                $avatarSrc = "data:image/*;base64," . base64_encode($_SESSION['auth_avatar']);
                            else
                                $avatarSrc = "./assets/images/icons/avatar.jpg";
                            ?>
                            <img alt="avatar" src="<?=$avatarSrc?>" class="rounded-circle" />
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end"
                         aria-labelledby="dropdownUser">
                        <div class="px-4 pb-0 pt-2">
                            <div class="lh-1 ">
                                <h5 class="mb-1"> <?=$_SESSION['auth_nickname']?></h5>
                                <a href="./player.php?id=<?=$_SESSION['auth_id']?>" class="text-inherit fs-6">View my profile</a>
                            </div>
                            <div class=" dropdown-divider mt-3 mb-2"></div>
                        </div>
                        <ul class="list-unstyled">
                            <li>
                                <a class="dropdown-item" href="./profile.php">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./logout.php">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Sign Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
            } else {
                ?>
                <li class="dropdown ms-2">
                    <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md">
                            <img alt="avatar" src="./assets/images/icons/login.png" class="rounded-circle" />
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <ul class="list-unstyled">
                            <li>
                                <a class="dropdown-item" href="./sign-in.php">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="log-in"></i>Sign In
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./sign-up.php">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user-plus"></i>Sign Up
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</div>
