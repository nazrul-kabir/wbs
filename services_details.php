<?php
include './config/config.php';
$service_id = '';
$service_title = '';
$service_details = '';
$service_image = '';
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
}
if ($service_id > 0 && $service_id != '') {
    $sql = "SELECT * FROM services WHERE service_id = $service_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $obj = mysqli_fetch_object($result);
        $service_title = $obj->service_title;
        $service_details = $obj->service_details;
        $service_image = $obj->service_image;
    }
}

$arrayService = array();
$sql = "SELECT * FROM services WHERE service_status='Active' ORDER BY service_id DESC";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($obj = mysqli_fetch_object($result)) {
        $arrayService[] = $obj;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $service_title; ?> | WATERBOND SHIPYARD BD LTD.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include './headerscript.php'; ?>
    </head>
    <body>
        <?php include './header.php'; ?>
        <?php include './menu.php'; ?>
        <section class="inner-banner">
            <div class="thm-container">
                <h2><?php echo $service_title; ?></h2>
                <ul class="breadcumb">
                    <li><a href="services.php"><i class="fa fa-home"></i>SERVICES</a></li>
                    <li><span><?php echo $service_title; ?></span></li>
                </ul>
            </div>
        </section>
        <section class="sec-padding single-service-page">
            <div class="thm-container">
                <div class="row">
                    <?php if (count($arrayService) > 0): ?>
                        <div class="col-md-4 pull-left">
                            <div class="single-sidebar-widget">
                                <div class="special-links">
                                    <ul>
                                        <?php foreach ($arrayService AS $service): ?>

                                            <li <?php if ($service_id == $service->service_id): ?>class="active" <?php endif; ?>><a href="services_details.php?id=<?php echo $service->service_id; ?>"><?php echo $service->service_title; ?></a></li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>					
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-8 pull-right tab-content">
                        <div class="tab-pane fade in active" id="ocean">
                            <div class="image-box clearfix">
                                <img style="height: 300px;width: 100%;" src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/service_image/' . $service_image; ?>" alt="<?php echo $service_title; ?>"/>
                            </div>
                            <div class="sec-title">
                                <h2><span><?php echo $service_title; ?></span></h2>
                                <p><?php echo html_entity_decode($service_details); ?></p>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
        </section>
        <?php include './footer.php'; ?> 
        <?php include './footerscript.php'; ?> 
    </body>
</html>