<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'vendor/autoload.php';

    ?>

    <?php

        if (!ifItIsMethod('get') && !isset($_GET['forgot_password'])) {

            redirect('index');
        }

        if (ifItIsMethod('post')) {

            if (isset($_POST['email'])) {

                $email = $_POST['email'];

                $length = 50;

                $token = bin2hex(openssl_random_pseudo_bytes($length));

                if (emailExists($email)) {

                    $stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);

                    if (!$stmt) {
                        die("Upit nije uspeo " . mysqli_error($connection));
                    }

                    mysqli_stmt_close($stmt);

                    /**
                    *
                    * konfigurisanje PHPMailer-a
                    *
                    *
                    */

                    $mail = new PHPMailer();

                    try {
                        //Server settings
                        $mail->SMTPDebug = 0; // Enable verbose debug output
                        $mail->isSMTP(); // Set mailer to use SMTP
                        $mail->Host = Config::SMTP_HOST; // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true; // Enable SMTP authentication
                        $mail->Username = Config::SMTP_USERNAME; // SMTP username
                        $mail->Password = Config::SMTP_PASSWORD; // SMTP password
                        $mail->Port = Config::SMTP_PORT; // TCP port to connect to
                        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted

                        //Recipients
                        $mail->setFrom('stefanaritonovic@gmail.com', 'Stefan Aritonovic');
                        $mail->addAddress($email); // Add a recipient

                        //Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->CharSet = 'UTF-8';
                        $mail->Subject = 'Test email 8';
                        $mail->Body = '<p>Kliknite ovde kako biste resetovali Vašu lozinku <a href="http://localhost/cms/reset.php?email='. $email .'&token='. $token .'">http://localhost/cms/reset.php?email='. $email .'&token='. $token .'</a></p>';

                        if ($mail->send()) {
                            $emailSent = true;
                        }

                    } catch (Exception $e) {
                        echo 'Poruka nije poslata.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    }

                }
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
                                <?php if(!isset($emailSent)): ?>

                                    <div class="card-header">
                                        <h3 class="card-title">Zaboravili ste lozinku?</h3>
                                        <p class="card-text">Ovde je možete resetovati.</p>
                                    </div>
                                    <div class="card-body">
                                        <form class="form" role="form" action="" method="post" autocomplete="off" id="register-form">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="email" name="email" class="form-control" placeholder="Unesite email adresu">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Resetuj lozinku">
                                            </div>

                                            <input type="hidden" class="hide" name="token" id="token" value="">
                                        </form>
                                    </div>
                                    <!--/card-body-->

                                <?php else: ?>

                                    <div class="card-footer">
                                        <h4 class="card-title">Proverite Vašu email adresu</h4>
                                    </div>
                                    <!--/card-footer-->

                                <?php endif; ?>

                            </div>
                            <!--/card-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php";?>
