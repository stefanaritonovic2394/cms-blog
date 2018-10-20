<?php include 'includes/admin_header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs -->
            <!-- <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol> -->
            <div class="row">
                <div class="col-lg-12">
                    <h1>Kategorije</h1>
                </div>
                <div class="col-6">

                    <?php insertCategories(); ?>

                    <form class="" action="" method="post">
                        <div class="form-group">
                            <label for="cat_title">Dodaj kategoriju</label>
                            <input type="text" class="form-control" name="cat_title">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Dodaj kategoriju">
                        </div>
                    </form>

                    <?php
                        // UPIT ZA AZURIRANJE KATEGORIJA
                        if (isset($_GET['edit'])) {
                            $cat_id = escape($_GET['edit']);

                            include 'includes/update_categories.php';
                        }
                    ?>

                </div>
                <div class="col-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Naslov Kategorije</th>
                                <th>Izmeni</th>
                                <th>Ukloni</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php findAllCategories(); ?>

                            <?php deleteCategories(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid-->

        <!-- Footer -->
        <?php include 'includes/admin_footer.php'; ?>
