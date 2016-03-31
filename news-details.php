<?php
include './config/config.php';
$news_id ='';
$news_title = '';
$news_details = '';
$news_status = 'Inactive';
$news_image = '';
$news_created_on = '';
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
}
$sql = "SELECT * FROM news WHERE news_id=$news_id";
$result = mysqli_query($con, $sql);
if ($result) {
    $obj = mysqli_fetch_object($result);
    $news_title = $obj->news_title;
    $news_details = $obj->news_details;
    $news_created_on = $obj->news_created_on;
    $news_image = $obj->news_image;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $news_title; ?> | Water Bond Shipyard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include './headerscript.php'; ?>
    </head>
    <body>
        <?php include './header.php'; ?>
        <?php include './menu.php'; ?>
        <section class="inner-banner">
            <div class="thm-container">
                <h2>News Details</h2>
                <ul class="breadcumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                    <li><span>News Details</span></li>
                </ul>
            </div>
        </section>


        <section class="sec-padding blog-page single-post-page ">
            <div class="thm-container">
                <div class="row">
                    <div class="col-md-4 pull-right">

                        <div class="single-sidebar-widget">
                            <div class="sec-title">
                                <h2><span>OUR SERVICES</span></h2>
                            </div>
                            <div class="categories">
                                <ul>
                                    <li class="active"><a href="services-building.php">Ship Building</a></li>
                                    <li><a href="services-repair.php">Ship Repair</a></li>
                                    <li><a href="services-engineering.php">General Engineering</a></li>
                                    <li><a href="services-sales.php">After Sales</a></li>
                                    <li ><a href="services-landing.php">Landing Station</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 pull-left">
                        <div class="single-post-wrapper">		
                            <article class="single-blog-post img-cap-effect">
                                <div class="img-box">
                                    <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/news_image/' . $news_image; ?>" alt="<?php echo $news_title; ?>"/>
                                </div>
                                <div class="meta-info">
                                    <div class="date-box">
                                        <div class="inner-box">
                                            <b><?php echo date('d',  strtotime($news_created_on)); ?></b>
                                            <?php echo date('M',  strtotime($news_created_on)); ?>
                                        </div>
                                    </div>
                                    <div class="content-box">
                                        <h3><?php echo $news_title; ?></h3>
                                    </div>
                                </div>
                                <p><?php echo html_entity_decode($news_details); ?></p>
                            </article>
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