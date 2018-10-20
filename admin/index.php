<?php include 'includes/admin_header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs -->
            <!-- <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol> -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dobrodošli na Admin stranu
                        <small></small>
                    </h1>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>
                                    <div>Postovi</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="card-footer bg-light">
                                <span class="pull-left">Pregled Detalja</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class='huge'><?php echo $comment_count = recordCount('comments'); ?></div>
                                    <div>Komentari</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="card-footer bg-light">
                                <span class="pull-left">Pregled Detalja</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-warning text-white">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class='huge'><?php echo $user_count = recordCount('users'); ?></div>
                                    <div>Korisnici</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="card-footer bg-light">
                                <span class="pull-left">Pregled Detalja</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-danger text-white">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class='huge'><?php echo $category_count = recordCount('categories'); ?></div>
                                    <div>Kategorije</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="card-footer bg-light">
                                <span class="pull-left">Pregled Detalja</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <?php

                $post_published_count = checkStatus('posts', 'post_status', 'objavljen');

                $post_draft_count = checkStatus('posts', 'post_status', 'nedovrsen');

                $unapproved_comment_count = checkStatus('comments', 'comment_status', 'neodobren');

                $subscriber_count = checkUserRole('users', 'user_role', 'pretplatnik');
            ?>

            <div class="">
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Podaci', 'Broj'],

                          <?php
                                $element_text = [
                                    'Svi Postovi',
                                    'Aktivni Postovi',
                                    'Nedovrseni Postovi',
                                    'Komentari',
                                    'Neodobreni Komentari',
                                    'Korisnici',
                                    'Pretplatnici',
                                    'Kategorije'
                                ];

                                $element_count = [
                                    $post_count,
                                    $post_published_count,
                                    $post_draft_count,
                                    $comment_count,
                                    $unapproved_comment_count,
                                    $user_count,
                                    $subscriber_count,
                                    $category_count
                                ];

                                for ($i = 0; $i < count($element_count) ; $i++) {
                                    echo "['{$element_text[$i]}'" . ", " . "{$element_count[$i]}],";
                                }
                          ?>


                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div id="columnchart_material" style="width: 'auto'; height: 400px;"></div>
            </div>
        </div>
        <!-- /.container-fluid-->

        <!-- Footer -->
        <?php include 'includes/admin_footer.php'; ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

        <script>

            $(document).ready(function(){

                var pusher = new Pusher('842ca913b68d613e14cb', {
                    cluster: 'us2',
                    encrypted: true
                });

                var notificationChannel = pusher.subscribe('notifications');
                notificationChannel.bind('new_user', function(notification){
                    var message = notification.message;
                    toastr.success(`${message} se upravo registrovao/la`);
                });

            });

        </script>
