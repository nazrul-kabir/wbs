<nav class="main-menu-wrapper stricky">
    <div class="thm-container menu-gradient ">
        <div class="clearfix">
            <div class="nav-holder pull-left">
                <div class="nav-header">
                    <button><i class="fa fa-bars"></i></button>
                </div>
                <div class="nav-footer">
                    <ul class="nav">
                        <li><a href="index.php">Home</a></li>
                        <li class="has-submenu">
                            <a href="about.php">about us</a>
                            <ul class="submenu">
                                <li><a href="company-history.php">Company History</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="services.php">Services</a>
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
                                <ul class="submenu">

                                    <?php foreach ($arrayService AS $service): ?>
                                        <li><a href="services_details.php?id=<?php echo $service->service_id; ?>"><?php echo $service->service_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <li><a href="news_list.php">News</a></li>
                        <li><a href="contact-us.php">contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class="free-qoute-button pull-right">				
                <a href="#">Get Free Quote</a>
            </div>
        </div>
    </div>
</nav>