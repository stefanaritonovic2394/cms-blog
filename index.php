<?php ob_start(); ?>
<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    $per_page = 2;

                    if (isset($_GET['page'])) {

                        $page = $_GET['page'];
                    } else {

                        $page = "";
                    }

                    if ($page == "" || $page == 1) {

                        $page_1 = 0;

                    } else {

                        $page_1 = ($page * $per_page) - $per_page;
                    }

                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {

                        $post_query_count = "SELECT * FROM posts";

                    } else {

                        $post_query_count = "SELECT * FROM posts WHERE post_status = 'objavljen'";

                    }

                    $find_count = mysqli_query($connection, $post_query_count);
                    $count = mysqli_num_rows($find_count);

                    if ($count < 1) {
                        echo "<h1 class='my-4 text-center'>Nema postova</h1>";
                    } else {

                    $count = ceil($count / $per_page);

                    $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_image = $row['post_image'];
                        $post_title = $row['post_title'];
                        $post_content = substr($row['post_content'], 0, 100);
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_status = $row['post_status'];

                ?>

                <!-- <h1 class="my-4">Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- Blog Post -->
                <div class="card my-4">
                    <a href="post/<?php echo $post_id; ?>">
                        <img class="card-img-top" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="Card image cap">
                    </a>
                    <div class="card-body">
                        <h2 class="card-title">
                            <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="card-text"><?php echo $post_content; ?></p>
                        <a href="post/<?php echo $post_id; ?>" class="btn btn-primary">Pročitaj Više &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">
                        Objavio <a href="author_posts.php?user=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                        datuma <?php echo $post_date; ?>
                    </div>
                </div>

                <?php } } ?>

                <!-- Pagination -->
                <ul class="pagination justify-content-center mb-4">
                    <?php

                        if($page != 1 && $page != "") {
                            $prev_page = $page - 1;
                            echo "<li class='page-item'><a class='page-link' href='index.php?page={$prev_page}'>Prethodna</a></li>";
                        }

                        for($i = 1; $i <= $count; $i++) {

                            if($i == $page || ($i == 1 && $page == "")) {

                                echo "<li class='page-item active'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
                            } else {

                                echo "<li class='page-item'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
                            }

                        }

                        if($page != $count && $page != "") {
                            $next_page = $page + 1;
                            echo "<li class='page-item'><a class='page-link' href='index.php?page={$next_page}'>Sledeća</a></li>";
                        }

                    ?>
                    <!-- <li class="page-item">
                        <a class="page-link" href="#">&larr; Starije</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Novije &rarr;</a>
                    </li> -->
                </ul>

            </div>

            <!-- Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
