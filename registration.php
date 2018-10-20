<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <?php

        require 'vendor/autoload.php';

        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();

        $options = array(
            'cluster' => 'us2',
            'encrypted' => true
        );

        $pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $username = escape($_POST['username']);
            $email = escape($_POST['email']);
            $password = escape($_POST['password']);

            $error = [
                'username' => '',
                'email' => '',
                'password' => ''
            ];

            if (strlen($username) < 4) {

                $error['username'] = 'Korisnicko ime mora da bude duze';

            }

            if ($username == '') {

                $error['username'] = 'Korisnicko ime ne sme da bude prazno';

            }

            if (usernameExists($username)) {

                $error['username'] = 'Korisnicko ime vec postoji';

            }

            if ($email == '') {

                $error['email'] = 'Email adresa ne sme da bude prazna';

            }

            if (emailExists($email)) {

                $error['email'] = 'Email adresa vec postoji, <a href="index.php">Molimo Vas ulogujte se</a>';

            }

            if ($password == '') {

                $error['password'] = 'Lozinka ne sme da bude prazna';

            }

            foreach ($error as $key => $value) {

                if (empty($value)) {

                    unset($error[$key]);
                }

            }

            if (empty($error)) {

                registerUser($username, $email, $password);

                $data['message'] = $username;

                $pusher->trigger('notifications', 'new_user', $data);

                loginUser($username, $password);
            }

        }

    ?>

    <!-- Page Content -->
    <div class="container">

        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-wrap mt-5">
                            <h1>Registracija</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">Korisničko ime</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Unesite korisničko ime" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">

                                    <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Unesite email" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">

                                    <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Lozinka</label>
                                    <input type="password" class="form-control" name="password" id="key" placeholder="Unesite lozinku">

                                    <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-lg btn-block" name="register" id="btn-login" value="Registruj se">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php include 'includes/footer.php'; ?>
