<form class="" action="" method="post">
    <div class="form-group">
        <label for="cat_title">Izmeni kategoriju</label>

        <?php

            if (isset($_GET['edit'])) {

                $cat_id = escape($_GET['edit']);

                $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
                $select_categories_id = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                ?>

                <input type="text" class="form-control" name="cat_title" value="<?php if(isset($cat_title)) {echo $cat_title;} ?>">

            <?php } } ?>

            <?php

                // UPIT ZA IZMENU KATEGORIJE
                if (isset($_POST['update_category'])) {

                    $the_cat_title = escape($_POST['cat_title']);

                    $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");

                    mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id);

                    mysqli_stmt_execute($stmt);

                    if (!$stmt) {
                        die("Upit nije uspeo" . mysqli_error($connection));
                    }

                    mysqli_stmt_close($stmt);

                    redirect("./categories.php");

                }

            ?>

    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_category" value="Izmeni kategoriju">
    </div>
</form>
