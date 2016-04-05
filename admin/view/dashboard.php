<?php
include '../../config/config.php';

$totalClient = 0;
$totalService = 0;
$totalNews = 0;
$sqlProduct = "SELECT count(*) AS totalClient FROM clients";
$resultProduct = mysqli_query($con, $sqlProduct);
if ($resultProduct) {
    $objProduct = mysqli_fetch_object($resultProduct);
    $totalClient = $objProduct->totalClient;
}
$sqlService = "SELECT count(*) AS totalService FROM services";
$resultService = mysqli_query($con, $sqlService);
if ($resultService) {
    $objService = mysqli_fetch_object($resultService);
    $totalService = $objService->totalService;
}
$sqlNews = "SELECT count(*) AS totalNews FROM news";
$resultNews = mysqli_query($con, $sqlNews);
if ($resultNews) {
    $objNews = mysqli_fetch_object($resultNews);
    $totalNews = $objNews->totalNews;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include basePath('admin/header_script.php'); ?>
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php include basePath('admin/header.php'); ?>
            <aside class="main-sidebar">
                <?php include basePath('admin/site_menu.php'); ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Dashboard</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>&nbsp;Home</li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <section class="content">
                    <?php include basePath('admin/message.php'); ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion-ios-people-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Services</span>
                                    <span class="info-box-number"><?php echo $totalService; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion-ios-people-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Clients</span>
                                    <span class="info-box-number"><?php echo $totalClient; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion-ios-people-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total News</span>
                                    <span class="info-box-number"><?php echo $totalNews; ?></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>

            </div>
            <?php include basePath('admin/footer.php'); ?>
        </div>
        <script type="text/javascript">
            $("#dashActive").addClass("active");
            $("#dashActive").parent().parent().addClass("treeview active");
            $("#dashActive").parent().addClass("in");
        </script>

        <?php include basePath('admin/footer_script.php'); ?>
    </body>
</html>