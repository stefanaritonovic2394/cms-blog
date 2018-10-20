<?php include 'includes/admin_header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Komentari</h1>
                </div>
                <div class="col-12">
                    <?php

                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }

                        switch ($source) {
                            case 'add_post':
                                include 'includes/add_post.php';
                                break;

                            case 'edit_post':
                                include 'includes/edit_post.php';
                                break;

                            default:
                                include 'includes/view_all_comments.php';
                                break;
                        }

                    ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid-->

        <!-- Footer -->
        <?php include 'includes/admin_footer.php'; ?>
