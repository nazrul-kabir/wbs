<?php
$arrayBanner = array();
$sqlbanner = "SELECT * FROM banner WHERE banner_status='Active' ORDER BY banner_id DESC";
$resultBanner = mysqli_query($con, $sqlbanner);
if ($resultBanner) {
    while ($objBanner = mysqli_fetch_object($resultBanner)) {
        $arrayBanner[] = $objBanner;
    }
} else {
    
}
?>
<?php if (count($arrayBanner) > 0): ?>
    <section class="rev_slider_wrapper thm-banner-wrapper">
        <div id="slider2" class="rev_slider"  data-version="5.0">
            <ul class="tp-revslider-mainul" style="visibility: visible; display: block; overflow: hidden; width: 1903px; height: 100%; max-height: none; left: 0px;">
                <?php foreach ($arrayBanner AS $banner): ?>
                    <li data-transition="parallaxvertical" data-ease="SlowMo.ease">
                        <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/banner_image/' . $banner->banner_image; ?>"/>
                        <div class="tp-caption sfl tp-resizeme caption-h1 text-right" 
                             data-x="left" data-hoffset="0" 
                             data-y="bottom" data-voffset="30" 
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;" 
                             data-transform_in="o:0" 
                             data-transform_out="o:0" 
                             data-start="500">
                            <?php echo $banner->banner_title; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>