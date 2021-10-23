<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="./index.php">
            MisT
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link has-arrow active" href="./index.php">
                    <i data-feather="home" class="nav-icon icon-xs me-2"></i> Home
                </a>

            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow active" href="./store.php">
                    <i data-feather="shopping-cart" class="nav-icon icon-xs me-2"></i> Store
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link has-arrow active" href="./community.php">
                    <i data-feather="users" class="nav-icon icon-xs me-2"></i> Community
                </a>
            </li>

            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading"></div>
            </li>

            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navPages" aria-expanded="false" aria-controls="navPages">
                    <i data-feather="tool" class="nav-icon icon-xs me-2"> </i> Admin
                </a>

                <div id="navPages" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="./admin.php">
                                Games
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./genres.php">
                                Genres
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
