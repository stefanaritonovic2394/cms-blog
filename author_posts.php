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

                    if (isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                        $the_post_user = $_GET['user'];
                    }

                    $query = "SELECT * FROM posts WHERE post_user = '{$the_post_user}'";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_image = $row['post_image'];
                        $post_title = $row['post_title'];
                        $post_content = $row['post_content'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];

                ?>

                <h1 class="my-4">Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- Blog Post -->
                <div class="card mb-4">
                    <img class="card-img-top" src="images/<?php echo $post_image; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title">
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="card-text"><?php echo $post_content; ?></p>
                    </div>
                    <div class="card-footer text-muted">
                        Objavio <?php echo $post_user; ?>
                        datuma <?php echo $post_date; ?>
                    </div>
                </div>
                <?php } ?>

                <!-- Pagination -->
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Starije</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Novije &rarr;</a>
                    </li>
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
