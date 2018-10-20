<?php include '../includes/db.php'; ?>
<?php include './functions.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>

<?php

    if (!isset($_SESSION['user_role'])) {

        header('Location: ../index.php');

    } else {

        if (!isAdmin($_SESSION['username'])) {
            header('Location: ../index.php');
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin - Blog</title>

    <!-- Bootstrap core CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <link href="css/styles.css" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <!-- <script src="js/tinymce/tinymce.min.js"></script> -->

    <script src="js/jquery.js"></script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
