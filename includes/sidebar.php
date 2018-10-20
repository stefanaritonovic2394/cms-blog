<?php

    if (ifItIsMethod('post')) {

        if (isset($_POST['login'])) {

            if (isset($_POST['username']) && isset($_POST['password'])) {

                loginUser($_POST['username'], $_POST['password']);

            } else {

                redirect("index");

            }

        }

    }

?>

<div class="col-md-4">

    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">Pretraga</h5>
        <form action="search.php" method="post">
            <div class="card-body">
                <div class="input-group">
                    <input name="search" type="text" class="form-control" placeholder="Pretraži...">
                    <span class="input-group-btn">
                        <button name="submit" class="btn btn-secondary" type="submit">Kreni!</button>
                    </span>
                </div>
            </div>
        </form>
    </div>

    <!-- Login -->
    <div class="card my-4">

        <?php if(isset($_SESSION['user_role'])): ?>

            <h5 class="card-header">Ulogovani kao <?php echo $_SESSION['username']; ?></h5>
            <div class="card-body">
                <a href="includes/logout.php" class="btn btn-primary">Izlogujte se</a>
            </div>

        <?php else: ?>

            <h5 class="card-header">Logovanje</h5>
            <form method="post">
                <div class="card-body">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Unesite korisničko ime">
                    </div>
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" placeholder="Unesite lozinku">
                        <span class="input-group-btn">
                            <button name="login" class="btn btn-primary" type="submit">Ulogujte se</button>
                        </span>
                    </div>
                    <div class="form-group">
                        <a href="forgot_password.php?forgot_password=<?php echo uniqid(true); ?>" class="btn btn-link">Zaboravljena lozinka?</a>
                    </div>
                </div>
            </form>

        <?php endif; ?>

    </div>

    <!-- Categories Widget -->
    <div class="card my-4">

        <?php

            $query = "SELECT * FROM categories";
            $select_categories_sidebar = mysqli_query($connection, $query);

        ?>

        <h5 class="card-header">Kategorije</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled mb-0">

                        <?php

                            while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                            }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Side Widget -->
    <?php // include 'widget.php'; ?>

</div>
