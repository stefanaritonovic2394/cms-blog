<?php

    function imagePlaceholder($image='') {

        if (!$image) {

            return 'php-7.jpg';

        } else {

            return $image;
        }

    }

    function currentUser() {

        if (isset($_SESSION['username'])) {

            return $_SESSION['username'];

        }

        return false;

    }

    function redirect($location) {

        header('Location: ' . $location);
        exit();
    }

    function ifItIsMethod($method=null) {

        if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {

            return true;
        }

        return false;
    }

    function isLoggedIn() {

        if (isset($_SESSION['user_role'])) {

            return true;
        }

        return false;
    }

    function checkIfUserIsLoggedInAndRedirect($redirectLocation=null) {

        if (isLoggedIn()) {

            redirect($redirectLocation);
        }
    }

    function escape($string) {

        global $connection;
        return mysqli_real_escape_string($connection, trim(htmlentities($string)));

    }

    function usersOnline() {

        if (isset($_GET['onlineusers'])) {

            global $connection;

            if (!$connection) {

                session_start();
                include '../includes/db.php';

                $session = session_id();
                $time = time();
                $time_out_in_seconds = 05;
                $time_out = $time - $time_out_in_seconds;

                $query = "SELECT * FROM users_online WHERE session = '$session'";
                $send_query = mysqli_query($connection, $query);
                $count = mysqli_num_rows($send_query);

                if ($count == NULL) {
                    mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session', '$time')");
                } else {
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }

                $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
                echo $count_users = mysqli_num_rows($users_online_query);
            }

        }

    }

    usersOnline();

    function confirmQuery($result) {

        global $connection;

        if (!$result) {
            die("Upit nije uspeo " . mysqli_error($connection));
        }

    }

    function insertCategories() {

        global $connection;

        if (isset($_POST['submit'])) {
            $cat_title = escape($_POST['cat_title']);

            if ($cat_title == "" || empty($cat_title)) {
                echo "Ovo polje ne sme biti prazno";
            } else {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories (cat_title) VALUES (?)");

                mysqli_stmt_bind_param($stmt, 's', $cat_title);

                mysqli_stmt_execute($stmt);

                if (!$stmt) {
                    die('Upit nije uspeo' . mysqli_error($connection));
                }
            }

            mysqli_stmt_close($stmt);
        }

    }

    function findAllCategories() {

        global $connection;

        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?edit={$cat_id}'>Izmeni</a></td>";
            echo "<td><a href='categories.php?delete={$cat_id}'>Ukloni</a></td>";
            echo "</tr>";
        }

    }

    function deleteCategories() {

        global $connection;

        if (isset($_GET['delete'])) {
            $id_cat = escape($_GET['delete']);

            $query = "DELETE FROM categories WHERE cat_id = {$id_cat}";
            $delete_query = mysqli_query($connection, $query);
            header('Location: categories.php');
        }

    }

    function unApprove() {

        global $connection;

        if (isset($_GET['unapprove'])) {

            $the_comment_id = escape($_GET['unapprove']);

            $query = "UPDATE comments SET comment_status = 'neodobren' WHERE comment_id = {$the_comment_id}";
            $unapprove_comment_query = mysqli_query($connection, $query);
            header('Location: comments.php');
        }

    }

    function recordCount($table) {

        global $connection;

        $query = "SELECT * FROM " . $table;
        $select_all_posts = mysqli_query($connection, $query);
        $result = mysqli_num_rows($select_all_posts);

        confirmQuery($result);
        return $result;

    }

    function checkStatus($table, $column, $status) {

        global $connection;

        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $select_all_published_posts = mysqli_query($connection, $query);
        $result = mysqli_num_rows($select_all_published_posts);

        confirmQuery($result);
        return $result;
    }

    function checkUserRole($table, $column, $role) {

        global $connection;

        $query = "SELECT * FROM $table WHERE $column = '$role'";
        $select_all_subscribers = mysqli_query($connection, $query);
        $result = mysqli_num_rows($select_all_subscribers);

        confirmQuery($result);
        return $result;
    }

    function isAdmin($username) {

        global $connection;

        $query = "SELECT user_role FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        $row = mysqli_fetch_array($result);

        if ($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }

    }

    function usernameExists($username) {

        global $connection;

        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    function emailExists($email) {

        global $connection;

        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    function registerUser($username, $email, $password) {

        global $connection;

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$email}', '$password', 'pretplatnik')";
        $register_user_query = mysqli_query($connection, $query);

        confirmQuery($register_user_query);

    }

    function loginUser($username, $password) {

        global $connection;

        $username = escape($username);
        $password = escape($password);

        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user_query = mysqli_query($connection, $query);

        if (!$select_user_query) {
            die("Upit nije uspeo " . mysqli_error($connection));
        }

        while ($row = mysqli_fetch_array($select_user_query)) {
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];

            if (password_verify($password, $db_user_password)) {

                session_start();

                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;

                redirect("/cms/admin");

            } else {

                return false;
            }

        }

        return true;

    }

?>
