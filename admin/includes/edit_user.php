<?php

    if (isset($_GET['u_id'])) {
        $the_user_id = escape($_GET['u_id']);

        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_users_by_id = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users_by_id)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }

?>

<?php

    if (isset($_POST['edit_user'])) {

        $username = escape($_POST['username']);
        $user_password = escape($_POST['user_password']);
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);
        $user_role = escape($_POST['user_role']);

        if (!empty($user_password)) {

            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
            $get_user_query = mysqli_query($connection, $query_password);
            confirmQuery($get_user_query);

            $row = mysqli_fetch_array($get_user_query);

            $db_user_password = $row['user_password'];

            if ($db_user_password != $user_password) {

                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }

            $query = "UPDATE users SET ";
            $query.= "user_firstname = '{$user_firstname}', ";
            $query.= "user_lastname = '{$user_lastname}', ";
            $query.= "user_role = '{$user_role}', ";
            $query.= "username = '{$username}', ";
            $query.= "user_email = '{$user_email}', ";
            $query.= "user_password = '{$hashed_password}' ";
            $query.= "WHERE user_id = {$the_user_id}";

            $edit_user_query = mysqli_query($connection, $query);

            confirmQuery($edit_user_query);

            echo "<p class='alert alert-success'>Korisnik Izmenjen: " . " " . "<a href='users.php'>Pregled Korisnika</a></p>";

        }

    }

} else {

    header('Location: index.php');
}

?>

<form class="" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Ime</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="title">Prezime</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>
    <div class="form-group">
        <select class="custom-select" name="user_role">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php

                if ($user_role == 'admin') {
                    echo "<option value='pretplatnik'>pretplatnik</option>";
                } else {
                    echo "<option value='admin'>admin</option>";
                }

            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="post_image">Slika Posta</label>
        <input type="file" class="form-control-file" name="image">
    </div> -->
    <div class="form-group">
        <label for="username">Korisničko ime</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Lozinka</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Izmeni korisnika">
    </div>
</form>
