<?php
include './config/config.php';
$array = array();
$sql = mysqli_query($con, "SELECT * FROM news WHERE news_status = 'Active' ORDER BY news_id DESC");

$total = mysqli_num_rows($sql);

$adjacents = 3;
$targetpage = "news_list.php";
$limit = 3;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 0;
}

if ($page) {
    $start = ($page - 1) * $limit;
} else {
    $start = 0;
}

if ($page == 0) {
    $page = 1;
}
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total / $limit);
$lpm1 = $lastpage - 1;
$sql2 = "SELECT * FROM news WHERE news_status = 'Active'ORDER BY news_id DESC LIMIT $start ,$limit";
$sql_query = mysqli_query($con, $sql2);
while ($obj = mysqli_fetch_object($sql_query)) {
    $array[] = $obj;
}


/* CREATE THE PAGINATION */
$counter = '';
$pagination = "";
if ($lastpage > 1) {
    $pagination .= "<ul class='pagination'>";
    if ($page > $counter + 1) {
        $pagination.= "<li><a href=\"$targetpage?page=$prev\">Prev</a></li>";
    }
    if ($lastpage < 7 + ($adjacents * 2)) {
        for ($counter = 1; $counter <= $lastpage; $counter++) {
            if ($counter == $page) {
                $pagination.= "<li class='active'><a href='#'>$counter</a></li>";
            } else {
                $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
            }
        }
    } elseif ($lastpage > 5 + ($adjacents * 2)) {
        if ($page < 1 + ($adjacents * 2)) {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                if ($counter == $page)
                    $pagination.= "<li class='active'><a href='#' >$counter</a></li>";
                else
                    $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
            }
            $pagination.= "<li></li>";
            $pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
            $pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
        }
        elseif ($lastpage - ($adjacents * 2) > $page & $page > ($adjacents * 2)) {
            $pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
            $pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
            $pagination.= "<li></li>";
            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                if ($counter == $page) {
                    $pagination.= "<li class='active'><a href='#'>$counter</a></li>";
                } else {
                    $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
                }
            }
            $pagination.= "<li></li>";
            $pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
            $pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
        } else {
            $pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
            $pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
            $pagination.= "<li></li>";
            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $pagination.= "<li class='active'><a href='#'>$counter</a></li>";
                } else {
                    $pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
                }
            }
        }
    }
    if ($page < $counter - 1) {
        $pagination.= "<li><a href=\"$targetpage?page=$next\">Next</a></li>";
    } else {
        $pagination.= "";
        $pagination.= "</ul>\n";
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
        <title>News List | WATERBOND SHIPYARD BD LTD.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include './headerscript.php'; ?>
    </head>
    <body>
        <?php include './header.php'; ?>
        <?php include './menu.php'; ?>
        <section class="inner-banner">
            <div class="thm-container">
                <h2>News List</h2>
                <ul class="breadcumb">
                    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                    <li><span>News List</span></li>
                </ul>
            </div>
        </section>


        <section class="sec-padding blog-page single-post-page ">
            <div class="thm-container">
                <div class="row">
                     <?php if (count($arrayService) > 0): ?>
                    <div class="col-md-4 pull-right">
                        
                        <div class="single-sidebar-widget">
                            <div class="sec-title">
                                <h2><span>OUR SERVICES</span></h2>
                            </div>
                            <div class="categories">
                                <ul>
                                     <?php foreach ($arrayService AS $service): ?>
                                    <li><a href="services_details.php?id=<?php echo $service->service_id; ?>"><?php echo $service->service_title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-8 pull-left">
                        <?php if (count($array) > 0): ?>
                            <?php foreach ($array AS $news): ?>
                                <div class="single-post-wrapper">		
                                    <article class="single-blog-post img-cap-effect">
                                        <div class="">
                                            <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/news_image/' . $news->news_image; ?>" alt="<?php echo $news->news_title; ?>" class="img-responsive"/>           
                                        </div>
                                        <div class="meta-info">
                                            <div class="date-box">
                                                <div class="inner-box">
                                                    <b><?php echo date('d', strtotime($news->news_created_on)); ?></b>
                                                    <?php echo date('M', strtotime($news->news_created_on)); ?>
                                                </div>
                                            </div>
                                            <div class="content-box">
                                                <a href="news-details.php?id=<?php echo $news->news_id; ?>"><h3><?php echo $news->news_title; ?></h3></a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php echo $pagination; ?>
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
                            <a class="thm-btn" href="contact-us.php">Contact Us <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include './footer.php'; ?>
        <?php include './footerscript.php'; ?>
    </body>
</html>