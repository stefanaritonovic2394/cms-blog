<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'admin/functions.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    if (isset($_GET['category'])) {
                        $post_category_id = escape($_GET['category']);

                        if (isset($_SESSION['user_role']) && isAdmin($_SESSION['username'])) {

                            $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

                        } else {

                            $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");

                            $published = 'objavljen';

                        }

                        if (isset($stmt1)) {

                            mysqli_stmt_bind_param($stmt1, "i", $post_category_id);

                            mysqli_stmt_execute($stmt1);

                            mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                            $stmt = $stmt1;

                        } else {

                            mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);

                            mysqli_stmt_execute($stmt2);

                            mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                            $stmt = $stmt2;

                        }

                        mysqli_stmt_store_result($stmt);

                        $count = mysqli_stmt_num_rows($stmt);

                        if ($count === 0) {

                            echo "<h1 class='my-4 text-center'>Nema kategorija</h1>";

                        }

                        while (mysqli_stmt_fetch($stmt)):


                ?>

                <!-- <h1 class="my-4">Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- Blog Post -->
                <div class="card my-4">
                    <a href="/cms/post/<?php echo $post_id; ?>">
                        <img class="card-img-top" src="/cms/images/<?php echo $post_image; ?>" alt="Card image cap">
                    </a>
                    <div class="card-body">
                        <h2 class="card-title">
                            <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="card-text"><?php echo $post_content; ?></p>
                        <a href="#" class="btn btn-primary">Pročitaj Više &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">
                        Objavio <a href="#"><?php echo $post_author; ?></a>
                        datuma <?php echo $post_date; ?>
                    </div>
                </div>
                <?php endwhile; mysqli_stmt_close($stmt); } else {

                    header('Location: index.php');

                } ?>

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

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
