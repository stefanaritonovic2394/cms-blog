<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<?php

    if (isset($_POST['submit'])) {

        $to = "stefanaritonovic@gmail.com";
        $subject = $_POST['subject'];
        $body = wordwrap($_POST['body'], 70);
        $header = "From: " . $_POST['email'];

        if (!empty($subject) && !empty($body) && !empty($header)) {

            mail($to, $subject, $body, $header);

            $message = "<div class='alert alert-success' role='alert'>Uspešno ste poslali poruku</div>";

        } else {

            $message = "<div class='alert alert-danger' role='alert'>Polja ne mogu biti prazna</div>";

        }

    } else {

        $message = "";

    }

?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-wrap mt-5">
                            <h1>Kontakt</h1>
                            <form role="form" action="" method="post" id="login-form" autocomplete="off">
                                <h6 class="text-center"><?php echo $message; ?></h6>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Unesite email">
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="sr-only">Naslov</label>
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Unesite naslov">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="body" id="body" rows="5" cols="30" placeholder="Unesite poruku"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-lg btn-block" name="submit" id="btn-login" value="Pošalji">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php include 'includes/footer.php'; ?>
