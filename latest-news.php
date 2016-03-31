<?php
$newsarray = array();
$countpost = 0;
$sqlpost = "SELECT * FROM news WHERE news_status='Active' ORDER BY news_id DESC LIMIT 2";
$resultnews = mysqli_query($con, $sqlpost);
if ($resultnews) {
    while ($objpost = mysqli_fetch_object($resultnews)) {
        $newsarray[] = $objpost;
    }
}
?>
<?php if (count($resultnews) > 0): ?>
    <section class="latest-blog sec-padding">
        <div class="thm-container">
            <div class="sec-title">
                <h2><span>Latest News</span></h2>
            </div>
            <div class="row">
                <?php foreach ($newsarray AS $news): ?>
                    <div class="col-md-6">

                        <div class="single-blog-post img-cap-effect">
                            <div class="img-box">
                                <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/news_image/' . $news->news_image; ?>" title="<?php echo $news->posttitle; ?>" alt="<?php echo $news->posttitle; ?>" style="height: 277px; width: 270px;"/>
                                <div class="img-caption">
                                    <div class="box-holder">
                                        <ul>
                                            <li><a href="news-details.php?id=<?php echo $news->news_id; ?>"><i class="fa fa-link"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-box">
                                <div class="date">
                                    <span><?php echo date('d', strtotime($news->news_created_on)); ?></span>/<?php echo date('M', strtotime($news->news_created_on)); ?>
                                </div>
                                <a href="news-details.php?id=<?php echo $news->news_id; ?>"><h3><?php echo $news->news_title; ?></h3></a>
                                <p><?php echo html_entity_decode(shorten_string($news->news_details,20)); ?></p>
                                <a href="news-details.php?id=<?php echo $news->news_id; ?>" class="thm-btn">Read More <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>