<footer id="footer" class="sec-padding">
    <div class="thm-container">
        <div class="row">
            <div class="col-md-3 col-sm-6 footer-widget">
                <div class="about-widget">
                    <a href="index.php"><img src="images/wbs-logo.png" alt="Water Bond Shipyard"/></a>
                    <p>Water Bond Shipyard, known as one of the leading shipbuilder of Bangladesh.</p>
                    <a href="about.php">Read More <i class="fa fa-angle-double-right"></i></a>
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 footer-widget">
                <div class="pl-30">
                    <div class="title">
                        <h3><span>Our Services</span></h3>
                    </div>
                    <?php
                    $arrayService = array();
                    $sql = "SELECT * FROM services WHERE service_status='Active' ORDER BY service_id DESC";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        while ($obj = mysqli_fetch_object($result)) {
                            $arrayService[] = $obj;
                        }
                    }
                    ?>
                    <?php if (count($arrayService) > 0): ?>
                        <ul class="link-list">
                            <?php foreach ($arrayService AS $service): ?>
                                <li><a href="services_details.php?id=<?php echo $service->service_id; ?>"><?php echo $service->service_title; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 footer-widget">
                <div class="title">
                    <h3><span>Quick Links</span></h3>
                </div>
                <ul class="link-list">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Our Services</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="news_list.php">News</a></li>
                    <li><a href="contact-us.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-6 footer-widget">
                <div class="title">
                    <h3><span>Quick Links</span></h3>
                </div>
                <ul class="contact-infos">
                    <li>
                        <div class="icon-box">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="text-box">
                            <p><b>Water Bond Shipyard Ltd.</b></p>
                            <p>House: 27, Road: 3, Nikunja 1</p>
                            <p>Dhaka, Bangladesh</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon-box">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="text-box">
                            <p>+88 02 8900082  /+88 02 8900159</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon-box">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <div class="text-box">
                            <p>contact@wms.com</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon-box">
                            <i class="icon icon-Timer"></i>
                        </div>
                        <div class="text-box">
                            <p>Sunday - Thursday : 8.00 - 19.00</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<section class="bottom-bar">
    <div class="thm-container clearfix">
        <div class="pull-left">
            <p>Copyright © Water Bond Shipyard 2016. All rights reserved.</p>
        </div>
        <div class="pull-right">
            <p>Created by: <a href="http://www.arkhairul.com" target="_blank">MK IT Geeks</a></p>
        </div>
    </div>
</section>