<?php
include './config/config.php';
$arrayService = array();
$sql = "SELECT * FROM services WHERE service_status='Active' ORDER BY service_id DESC";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($obj = mysqli_fetch_object($result)) {
        $arrayService[] = $obj;
    }
}
//debug($arrayService);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Services | WATERBOND SHIPYARD BD LTD.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include './headerscript.php'; ?>
    </head>
    <body>
        <?php include './header.php'; ?>
        <?php include './menu.php'; ?>
        <section class="inner-banner">
            <div class="thm-container">
                <h2>Services</h2>
                <ul class="breadcumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                    <li><span>Services</span></li>
                </ul>
            </div>
        </section>



        <section class="sec-padding page-title">
            <div class="thm-container">
                <div class="sec-title">
                    <h2><span>We offer different services</span></h2>
                </div>
            </div>
        </section>

        <?php if (count($arrayService) > 0): ?>
            <section class="services-section sec-padding">
                <div class="thm-container">
                    <div class="row">
                        <?php foreach ($arrayService AS $service): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="single-services img-cap-effect">
                                    <div class="img-box">
                                        <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/service_image/' . $service->service_image; ?>" alt="<?php echo $service->service_title; ?>"/>
                                        <div class="img-caption">
                                            <div class="box-holder">
                                            </div>
                                        </div>
                                    </div>
                                    <h3><span><?php echo $service->service_title; ?></span></h3>
                                    <p><?php echo html_entity_decode(shorten_string($service->service_details, 20)); ?></p>
                                    <a href="services_details.php?id=<?php echo $service->service_id; ?>">Read More <i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

        <?php endif; ?>

        <section class="fact-counter sec-padding">
            <div class="thm-container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="single-fact-counter">
                            <div class="icon-box">
                                <i class="icon icon-User"></i>
                            </div>
                            <div class="text-box">
                                <h4 class="timer" data-from="0" data-to="250"></h4>
                                <p>Emploies in Team</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-fact-counter">
                            <div class="icon-box">
                                <i class="icon icon-BigTruck"></i>
                            </div>
                            <div class="text-box">
                                <h4 class="timer" data-from="0" data-to="106"></h4>
                                <p>Company Vihicles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-fact-counter">
                            <div class="icon-box">
                                <i class="icon icon-WorldGlobe"></i>
                            </div>
                            <div class="text-box">
                                <h4 class="timer" data-from="0" data-to="406"></h4>
                                <p>Worldwide Clients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-fact-counter">
                            <div class="icon-box">
                                <i class="icon icon-Briefcase"></i>
                            </div>
                            <div class="text-box">
                                <h4 class="timer" data-from="0" data-to="308"></h4>
                                <p>Projects Done</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="footer-top">
            <div class="thm-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <h3>Logistic and cargo</h3>
                            <p>Contact us now to get quote for all your global <br>shipping and cargo need.</p>
                        </div>
                        <div class="col-md-6">
                            <a class="thm-btn" href="contact.php">Contact Us <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include './footer.php'; ?>
        <?php include './footerscript.php'; ?>
    </body>
</html>