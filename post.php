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

                    if (isset($_GET['p_id'])) {
                        $the_post_id = escape($_GET['p_id']);

                        $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id";
                        $send_query = mysqli_query($connection, $view_query);

                        if (!$send_query) {
                            die('Upit nije uspeo' . mysqli_error($connection));
                        }

                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {

                            $post_id_query_count = "SELECT * FROM posts WHERE post_id = $the_post_id";

                        } else {

                            $post_id_query_count = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'objavljen'";
                        }

                        $find_count = mysqli_query($connection, $post_id_query_count);
                        $count = mysqli_num_rows($find_count);

                        if ($count < 1) {

                            echo "<h1 class='my-4 text-center'>Nema postova</h1>";

                        } else {

                        while ($row = mysqli_fetch_assoc($find_count)) {
                            $post_image = $row['post_image'];
                            $post_title = $row['post_title'];
                            $post_content = $row['post_content'];
                            $post_user = $row['post_user'];
                            $post_date = $row['post_date'];

                ?>

                <!-- <h1 class="my-4">Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- Blog Post -->
                <div class="card my-4">
                    <img class="card-img-top" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title">
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="card-text"><?php echo $post_content; ?></p>
                    </div>
                    <div class="card-footer text-muted">
                        Objavio <a href="#"><?php echo $post_user; ?></a>
                        datuma <?php echo $post_date; ?>
                    </div>
                </div>
                <?php } ?>

                <?php

                    if (isset($_POST['create_comment'])) {

                        $the_post_id = escape($_GET['p_id']);

                        $comment_author = escape($_POST['comment_author']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";

                            $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'neodobren', now())";

                            $create_comment_query = mysqli_query($connection, $query);

                            if (!$create_comment_query) {
                                die('Upit nije uspeo' . mysqli_error($connection));
                            }

                            // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";
                            // $update_comment_count = mysqli_query($connection, $query);
                        } else {
                            echo "<script>alert('Polja ne mogu biti prazna');</script>";
                        }
                    }

                ?>

                <!-- Comments Form -->
                <?php if(isLoggedIn()): ?>

                    <div class="card my-4">
                        <h5 class="card-header">Ostavi Komentar:</h5>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="author">Autor</label>
                                    <input type="text" class="form-control" name="comment_author" placeholder="Unesite ime autora" value="">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="comment_email" placeholder="Unesite email" value="">
                                </div>
                                <div class="form-group">
                                    <label for="comment">Vaš Komentar</label>
                                    <textarea class="form-control" name="comment_content" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="create_comment">Pošalji</button>
                            </form>
                        </div>
                    </div>

                <?php else: ?>

                    <div class="card my-4">
                        <h5 class="card-header">Niste ulogovani</h5>
                        <div class="card-body">
                            <p class="card-text">Ulogujte se kako bi mogli da ostavite komentar!</p>
                        </div>
                    </div>

                <?php endif; ?>

                <?php

                    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'odobren' ORDER BY comment_id DESC";
                    $select_comment_query = mysqli_query($connection, $query);

                    if (!$select_comment_query) {
                        die('Upit nije uspeo' . mysqli_error($connection));
                    }

                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];

                ?>

                <!-- Single Comment -->
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo $comment_author; ?></h5>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

                <?php } } } else {
                    header('Location: index.php');
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

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
