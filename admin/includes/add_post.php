<?php

    if (isset($_POST['create_post'])) {

        $post_title = escape($_POST['title']);
        // $post_author = $_POST['author'];
        $post_user = escape($_POST['post_user']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);

        $post_image = escape($_FILES['image']['name']);
        $post_image_temp = escape($_FILES['image']['tmp_name']);

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);
        $post_date = escape(date('d-m-y'));

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES ({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

        $create_post_query = mysqli_query($connection, $query);

        confirmQuery($create_post_query);

        $the_post_id = mysqli_insert_id($connection);

        echo "<p class='alert alert-success'>Post Dodat. <a href='../post.php?p_id={$the_post_id}'>Pregledaj Post</a> ili <a href='posts.php'>Izmeni Još Postova</a></p>";

    }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Naslov Posta</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="category">Kategorija</label><br>
        <select class="custom-select" name="post_category">
            <?php

                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);

                confirmQuery($select_categories);

                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<option value='$cat_id'>{$cat_title}</option>";
                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="user">Korisnik</label><br>
        <select class="custom-select" name="post_user">
            <?php

                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection, $query);

                confirmQuery($select_users);

                while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];

                    echo "<option value='$username'>{$username}</option>";
                }

            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="author">Autor Posta</label>
        <input type="text" class="form-control" name="author">
    </div> -->
    <div class="form-group">
        <label for="status">Status</label><br>
        <select class="custom-select" name="post_status">
            <option value='nedovrsen'>Status Posta</option>
            <option value='objavljen'>Objavljen</option>
            <option value='nedovrsen'>Nedovrsen</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Slika Posta</label>
        <input type="file" class="form-control-file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Tagovi Posta</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Sadržaj Posta</label>
        <textarea class="form-control" name="post_content" id="" rows="10" cols="30"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Dodaj post">
    </div>
</form>
