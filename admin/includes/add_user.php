<?php

    if (isset($_POST['create_user'])) {

        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);

        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

        $query = "INSERT INTO users (user_firstname, user_lastname, user_role, username, user_email, user_password) VALUES ('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}')";

        $create_user_query = mysqli_query($connection, $query);

        confirmQuery($create_user_query);

        echo "<p class='alert alert-success'>Korisnik Dodat: " . " " . "<a href='users.php'>Pregled Korisnika</a></p>";

    }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Ime</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Prezime</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <select class="custom-select" name="user_role">
            <option value="pretplatnik">Odaberite opciju</option>
            <option value="admin">Admin</option>
            <option value="pretplatnik">Pretplatnik</option>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="post_image">Slika Posta</label>
        <input type="file" class="form-control-file" name="image">
    </div> -->
    <div class="form-group">
        <label for="username">Korisničko ime</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Lozinka</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Dodaj korisnika">
    </div>
</form>
