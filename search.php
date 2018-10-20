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

                    if (isset($_POST['submit'])) {

                        $search = escape($_POST['search']);

                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {

                            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";

                        } else {

                            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'objavljen'";

                        }

                        $search_query = mysqli_query($connection, $query);

                        if (!$search_query) {
                            die("Upit nije uspeo" . mysqli_error($connection));
                        }

                        $count = mysqli_num_rows($search_query);

                        if ($count == 0) {
                            echo "<h1 class='my-4 text-center'>Ne postoje rezultati</h1>";
                        } else {

                            while ($row = mysqli_fetch_assoc($search_query)) {
                                $post_image = $row['post_image'];
                                $post_title = $row['post_title'];
                                $post_content = $row['post_content'];
                                $post_date = $row['post_date'];
                                $post_author = $row['post_author'];

                                ?>

                                <!-- <h1 class="my-4">Page Heading
                                    <small>Secondary Text</small>
                                </h1> -->

                                <!-- Blog Post -->
                                <div class="card my-4">
                                    <img class="card-img-top" src="/cms/images/<?php echo $post_image; ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h2 class="card-title">
                                            <a href="#"><?php echo $post_title; ?></a>
                                        </h2>
                                        <p class="card-text"><?php echo $post_content; ?></p>
                                        <a href="#" class="btn btn-primary">Pročitaj Više &rarr;</a>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Objavio <a href="#"><?php echo $post_author; ?></a>
                                        datuma <?php echo $post_date; ?>
                                    </div>
                                </div>
                            <?php }
                        }

                    }
                    ?>

                <!-- Pagination -->
                <!-- <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Starije</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Novije &rarr;</a>
                    </li>
                </ul> -->

            </div>

            <!-- Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <?php include 'includes/footer.php'; ?>
