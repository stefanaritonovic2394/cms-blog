<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php">Admin</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Kontrolna tabla">
                <a class="nav-link" href="index.php">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Kontrolna tabla</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Postovi">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#posts_dropdown" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-file-text"></i>
                    <span class="nav-link-text">Postovi</span>
                </a>
                <ul class="sidenav-second-level collapse" id="posts_dropdown">
                    <li>
                        <a href="./posts.php">Pregled Svih Postova</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Dodaj Post</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Kategorije">
                <a class="nav-link" href="./categories.php">
                    <i class="fa fa-fw fa-list"></i>
                    <span class="nav-link-text">Kategorije</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Komentari">
                <a class="nav-link" href="./comments.php">
                    <i class="fa fa-fw fa-comments"></i>
                    <span class="nav-link-text">Komentari</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Korisnici">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-users"></i>
                    <span class="nav-link-text">Korisnici</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseExamplePages">
                    <li>
                        <a href="./users.php">Pregled Svih Korisnika</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Dodaj Korisnika</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profil">
                <a class="nav-link" href="profile.php">
                    <i class="fa fa-fw fa-user"></i>
                    <span class="nav-link-text">Profil</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <!-- <a class="nav-link" href="">Korisnici Online: <?php //echo usersOnline(); ?></a> -->
                <a class="nav-link" href="">Korisnici Online: <span class="usersonline"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Početna</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>
                    <?php

                        if (isset($_SESSION['username'])) {
                            echo $_SESSION['username'];
                        }

                    ?>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a class="dropdown-item" href="#"><i class="fa fa-user fa-fw"></i> Profil</a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="../includes/logout.php"><i class="fa fa-sign-out fa-fw"></i> Izloguj se</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </div>
</nav>
