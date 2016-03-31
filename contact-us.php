<?php
include './config/config.php';
$contact_name = '';
$contact_email = '';
$contact_subject = '';
$contact_message = '';
if (isset($_POST['btnSave'])) {
    extract($_POST);
    $contact_name = validateInput($contact_name);
    $contact_email = validateInput($contact_email);
    $contact_subject = validateInput($contact_subject);
    $contact_message = validateInput($contact_message);
    $custom_array = '';
    $custom_array .= 'contact_name = "' . $contact_name . '"';
    $custom_array .= ',contact_email = "' . $contact_email . '"';
    $custom_array .= ',contact_subject = "' . $contact_subject . '"';
    $custom_array .= ',contact_message = "' . $contact_message . '"';


    $sql = "INSERT INTO contact SET $custom_array";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $success = "Thank you for your query. We will get back to you soon";
        $contact_name = '';
        $contact_email = '';
        $contact_subject = '';
        $contact_message = '';
    } else {
        $error = "Something went wrongF";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="UTF-8">
        <title>Contact | WATERBOND SHIPYARD BD LTD.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include './headerscript.php'; ?>
    </head>
    <body>
        <?php include './header.php'; ?>
        <?php include './menu.php'; ?>
        <section class="inner-banner">
            <div class="thm-container">
                <h2>Contact Us</h2>
                <ul class="breadcumb">
                    <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                    <li><span>Contact Us</span></li>
                </ul>
            </div>
        </section>

        <section class="sec-padding contact-page-content">
            <div class="thm-container">
                <div class="sec-title">
                    <h2><span>Get in touch</span></h2>
                </div>
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-12 pull-left">
                        <p>You can talk to our representative at any time. Please use our website or fill up below instant messaging programs.</p>
                        <?php include './message.php'; ?>
                        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Enter Name" value="<?php echo $contact_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="Enter Email" value="<?php echo $contact_email; ?>" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="contact_subject" name="contact_subject" placeholder="Enter Subject" value="<?php echo $contact_subject; ?>" required />
                            </div>
                            <div class="form-group" >
                                <textarea class="form-control" id="contact_message" name="contact_message" rows="5" placeholder="Enter Message"><?php echo $contact_message; ?></textarea>
                            </div>
                            <button type="submit" id="form-submit" class="thm-btn" name="btnSave">Submit Now <i class="fa fa-arrow-right"></i></button>
                        </form>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 pull-right">
                        <div class="contact-info">
                            <ul>
                                <li>
                                    <div class="icon-box">
                                        <i class="icon icon-Pointer"></i>
                                    </div>
                                    <div class="content">
                                        <p>Waterbond Shipyard Ltd.</p>
                                        <p>House: 27, Road: 3, Nikunja 1</p>
                                        <p>Dhaka, Bangladesh</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-box">
                                        <i class="icon icon-Plaine"></i>
                                    </div>
                                    <div class="content">
                                        <p>info@wbs.com <br>support@wbs.com</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-box">
                                        <i class="icon icon-Phone2"></i>
                                    </div>
                                    <div class="content">
                                        <p>+88 02 8900082 <br>+88 02 8900159</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container">
                <div class="col-md-12">				
                    <p style="height: 10px;"></p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14599.403311008859!2d90.417973!3d23.823903!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c65a3d9b9649%3A0xff4da0194c977480!2sNikunja+1%2C+Dhaka%2C+Bangladesh!5e0!3m2!1sen!2sbd!4v1459397858538" width="1200" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </section>
        <?php include './footer.php'; ?>
        <?php include './footerscript.php'; ?>
    </body>
</html>