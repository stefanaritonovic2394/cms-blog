<?php

    if (isset($_GET['p_id'])) {
        $the_post_id = escape($_GET['p_id']);
    }

    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }

    if (isset($_POST['update_post'])) {

        $post_user = escape($_POST['post_user']);
        $post_title = escape($_POST['post_title']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);
        $post_image = escape($_FILES['image']['name']);
        $post_image_temp = escape($_FILES['image']['tmp_name']);
        $post_content = escape($_POST['post_content']);
        $post_tags = escape($_POST['post_tags']);

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if (empty($post_image)) {

            $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_array($select_image)) {
                $post_image = $row['post_image'];
            }

        }

        $query = "UPDATE posts SET ";
        $query.= "post_title = '{$post_title}', ";
        $query.= "post_category_id = '{$post_category_id}', ";
        $query.= "post_date = now(), ";
        $query.= "post_user = '{$post_user}', ";
        $query.= "post_status = '{$post_status}', ";
        $query.= "post_tags = '{$post_tags}', ";
        $query.= "post_content = '{$post_content}', ";
        $query.= "post_image = '{$post_image}' ";
        $query.= "WHERE post_id = {$the_post_id}";

        $update_post = mysqli_query($connection, $query);

        confirmQuery($update_post);

        echo "<p class='alert alert-success'>Post Izmenjen. <a href='../post.php?p_id={$the_post_id}'>Pregledaj Post</a> ili <a href='posts.php'>Izmeni Još Postova</a></p>";

    }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Naslov Posta</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
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

                    if ($cat_id == $post_category_id) {

                        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";

                    } else {

                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                    }

                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="user">Korisnik</label><br>
        <select class="custom-select" name="post_user">

            <?php echo "<option value='$post_user'>{$post_user}</option>"; ?>

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
        <input type="text" class="form-control" name="post_user" value="<?php // echo $post_author; ?>">
    </div> -->
    <div class="form-group">
        <label for="status">Status</label><br>
        <select class="custom-select" name="post_status">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>

            <?php

                if ($post_status == 'objavljen') {
                    echo "<option value='nedovrsen'>Nedovršen</option>";
                } else {
                    echo "<option value='objavljen'>Objavljen</option>";
                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Slika Posta</label><br>
        <img src="../images/<?php echo $post_image; ?>" width="100" alt="">
        <input type="file" class="form-control-file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Tagovi Posta</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Sadržaj Posta</label>
        <textarea class="form-control" name="post_content" id="" rows="10" cols="30"><?php echo str_replace('\r\n', '<br>', $post_content); ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Izmeni post">
    </div>
</form>
