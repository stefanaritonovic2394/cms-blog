<?php ob_start(); ?>
<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <?php

        checkIfUserIsLoggedInAndRedirect('/cms/admin');

        if (ifItIsMethod('post')) {

            if (isset($_POST['username']) && isset($_POST['password'])) {

                loginUser($_POST['username'], $_POST['password']);
            } else {

                redirect("/cms/login");
            }
        }

    ?>

    <!-- Page Content -->
    <div class="container">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="text-center mb-0">Logovanje</h3>
                                </div>
                                <div class="card-body">
                                    <form class="form" role="form" action="" method="post" autocomplete="off" id="login-form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <input type="text" name="username" class="form-control" placeholder="Unesite korisničko ime">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </div>
                                                <input type="password" name="password" class="form-control" placeholder="Unesite lozinku">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="login" class="btn btn-lg btn-primary btn-block" value="Ulogujte se">
                                        </div>
                                    </form>
                                </div>
                                <!--/card-body-->
                            </div>
                            <!--/card-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php";?>
