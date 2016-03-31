<?php
$array = array();
$sql = "SELECT * FROM services WHERE service_status='Active' ORDER BY service_id DESC LIMIT 4";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($obj = mysqli_fetch_object($result)) {
        $array[] = $obj;
    }
} else {
    
}
//debug($array);
?>
<?php if (count($array) > 0): ?>
    <section class="welcome-services">
        <div class="thm-container">
            <div class="row">
                <?php foreach ($array AS $service): ?>
                    <div class="col-md-6">
                        <div class="welcome-single-services">
                            <div class="img-box">
                                <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/service_image/' . $service->service_image; ?>" alt="<?php echo $service->service_title; ?>" style="height: 170px; width: 222px;">
                            </div>
                            <div class="text-box">
                                <div class="content">
                                    <h3><?php echo $service->service_title; ?></h3>
                                    <p><?php echo html_entity_decode($service->service_details); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>