<!DOCTYPE html>
<html lang="en">

<head>

    <?php
$title = $title;
?>


        <meta charset="utf-8" />
        <!-- <title>Dashboard | team</title> -->
        <title><?php echo $title; ?> | team</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="team" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url();?>/assets/images/favicon.ico">

        <!-- third party css -->
        <link href="<?php echo base_url();?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

        <!-- Plugins css -->
        <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
        
    <!-- App css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?php echo base_url();?>assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <link href="<?php echo base_url();?>assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- custom css -->
    <link href="<?php echo base_url();?>css/customstyles.css" rel="stylesheet" type="text/css" />

    <link href='https://fonts.googleapis.com/css?family=Poppins|Roboto|Oswald|Arial|Lobster|Pacifico|Satisfy|Bangers|Audiowide|Sacramento' rel='stylesheet' type='text/css' />  

    

            

            
</head>

<body class="loading right-bar-enabled sidebar-enable"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        <?php
include('topbar.php');
?>

        <?php
include('leftsidebar.php')
?>