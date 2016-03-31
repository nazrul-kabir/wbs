<?php
$arrayClient = array();
$sqlClient = "SELECT * FROM clients WHERE clients_status = 'Active'";
$result = mysqli_query($con, $sqlClient);
if ($result) {
    while ($obj = mysqli_fetch_object($result)) {
        $arrayClient[] = $obj;
    }
} else {
    
}
?>
<?php if (count($arrayClient) > 0): ?>
    <section class="our-client sec-padding">
        <div class="thm-container">
            <div class="sec-title">
                <h2><span>our clients</span></h2>
            </div>
            <div class="client-carousel">
                <div class="owl-carousel owl-theme">
                    <?php foreach ($arrayClient AS $client): ?>
                        <div class="item">
                            <img src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/clients_image/' . $client->clients_image; ?>" style="width: 173px; height: 133px;" alt="<?php echo $client->clients_name; ?>"/>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>