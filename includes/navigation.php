<?php session_start(); ?>
<?php require_once('./admin/functions.php'); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/cms">CMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">

                <?php

                    $query = "SELECT * FROM categories";
                    $select_all_categories_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        $category_class = '';
                        $registration_class = '';
                        $login_class = '';
                        $contact_class = '';

                        $page_name = basename($_SERVER['PHP_SELF']);

                        if (isset($_GET['category']) && $_GET['category'] == $cat_id) {

                            $category_class = 'active';

                        } else {

                            switch ($page_name) {
                                case 'registration.php':
                                    $registration_class = 'active';
                                    $login_class = '';
                                    $contact_class = '';
                                    break;

                                case 'login.php':
                                    $login_class = 'active';
                                    $registration_class = '';
                                    $contact_class = '';
                                    break;

                                case 'contact.php':
                                    $registration_class = '';
                                    $login_class = '';
                                    $contact_class = 'active';
                                    break;

                                default:
                                    $registration_class = '';
                                    $login_class = '';
                                    $contact_class = '';
                            }

                        }

                        // echo "<li class='nav-item'><a class='nav-link $category_class' href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                    }
                ?>

                <?php if(isLoggedIn()): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/cms/admin">Admin</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/cms/includes/logout.php">Izlogujte se</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class='nav-link <?php echo $login_class; ?>' href="/cms/login">Logovanje</a>
                    </li>

                <?php endif; ?>

                <li class="nav-item">
                    <a class='nav-link <?php echo $registration_class; ?>' href="/cms/registration">Registracija</a>
                </li>

                <li class="nav-item">
                    <a class='nav-link <?php echo $contact_class; ?>' href="/cms/contact">Kontakt</a>
                </li>

                <?php

                    if (isset($_SESSION['user_role'])) {

                        if (isset($_GET['p_id'])) {

                            $the_post_id = $_GET['p_id'];

                            echo "<li class='nav-item'><a class='nav-link' href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Izmeni Post</a></li>";
                        }

                    }
                ?>
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>
