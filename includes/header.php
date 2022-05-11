<?php ob_start(); ?>
<?php include("includes/connection.php"); ?>
<?php include("includes/function.php"); ?>
<?php include("includes/session.php"); ?>
<?php include("includes/default_values.php"); ?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Voting System</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="includes/w3.css">
        <link rel="stylesheet" href="plugins/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="plugins/icon-kit/dist/css/iconkit.min.css">
        <link rel="stylesheet" href="plugins/ionicons/dist/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/perfect-scrollbar/css/perfect-scrollbar.css">
        <link rel="stylesheet" href="plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
        <link rel="stylesheet" href="plugins/weather-icons/css/weather-icons.min.css">
        <link rel="stylesheet" href="plugins/c3/c3.min.css">
        <link rel="stylesheet" href="plugins/owl.carousel/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="plugins/owl.carousel/dist/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="dist/css/theme.min.css">
        <script src="src/js/vendor/modernizr-2.8.3.min.js"></script>
        <link rel="stylesheet" href="plugins/jquery-toast-plugin/dist/jquery.toast.min.css">
        <link rel="stylesheet" href="plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="plugins/summernote/dist/summernote-bs4.css">
        <link rel="stylesheet" href="plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
        <link rel="stylesheet" href="plugins/chartist/dist/chartist.min.css">
        
        <link rel="stylesheet" href="plugins/mohithg-switchery/dist/switchery.min.css">

        <!-- <script type="Text/Javascript" src="js/html2canvas.js"></script> -->
        <!-- <script type="Text/Javascript" src="js/html2canvas.min.js"></script> -->
        
        <script type="text/javascript" src="js\jquery.min.js"></script>
        <script type="Text/Javascript" src="js/jquery-3.1.1.min.js"></script>
        <script type="Text/Javascript" src="js/jquery-3.4.1.min.js"></script>
    
    <style type="text/css">
            table{cursor: pointer; font-size: 13px;text-transform: uppercase;}
            .w3-modal{color: black;}
            /*tr:hover{background-color: lightgray;}*/
            body{color: black; font-size: 13px;}
            .selectField{height: 50%; width: 100%; padding: 5px 5px 10px 5px; color: black;}
            .validation-area{color: red; font-weight: bold;}
            h1, h2, h3, h4, h5, h6 {text-transform: uppercase; font-weight: bold;}
        </style>
    </head>

    <body>