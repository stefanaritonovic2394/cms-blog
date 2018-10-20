<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <?php

        if (!isset($_GET['email']) && !isset($_GET['token'])) {

            redirect('index');
        }

        // $email = 'stefanaritonovic@gmail.com';
        //
        // $token = 'bda3498357fd3b30b0ac175ea1fa1b33ad4453d2640c5ba6f6f5100037a0a7b8f8306d14d5dfbc46f5c6eb95e50808a8ee40';

        $stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE token = ?");

        mysqli_stmt_bind_param($stmt, 's', $_GET['token']);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $username, $user_email, $token);

        mysqli_stmt_fetch($stmt);

        if (!$stmt) {
            die("Upit nije uspeo" . mysqli_error($connection));
        }

        mysqli_stmt_close($stmt);

        // if ($_GET['token'] !== $token || $_GET['email'] !== $user_email) {
        //
        //     redirect('index');
        //
        // }

        if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {

            if ($_POST['password'] === $_POST['confirmPassword']) {

                $password = $_POST['password'];
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                $stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '{$hashedPassword}' WHERE user_email = ?");

                mysqli_stmt_bind_param($stmt, 's', $_GET['email']);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) >= 1) {

                    redirect('/cms/login');

                }

                if (!$stmt) {
                    die("Upit nije uspeo" . mysqli_error($connection));
                }

                mysqli_stmt_close($stmt);

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
                            <div class="card text-center">
                                <div class="card-header">
                                    <h3 class="card-title">Resetovanje Lozinke</h3>
                                    <p class="card-text">Ovde je možete resetovati.</p>
                                </div>
                                <div class="card-body">
                                    <form class="form" role="form" action="" method="post" autocomplete="off" id="reset-form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-key" aria-hidden="true"></i>
                                                </div>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Unesite lozinku">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </div>
                                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Potvrdite lozinku">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Resetuj lozinku">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>
                                </div>
                            </div>
                            <!--/card-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php";?>
