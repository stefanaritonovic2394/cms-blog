<?php include 'includes/admin_header.php'; ?>

    <?php

        // if (!is_admin($_SESSION['username'])) {
        //
        //     header('Location: index.php');
        // }

    ?>

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Korisnici</h1>
                </div>
                <div class="col-12">
                    <?php

                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }

                        switch ($source) {
                            case 'add_user':
                                include 'includes/add_user.php';
                                break;

                            case 'edit_user':
                                include 'includes/edit_user.php';
                                break;

                            default:
                                include 'includes/view_all_users.php';
                                break;
                        }

                    ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid-->

        <!-- Footer -->
        <?php include 'includes/admin_footer.php'; ?>
