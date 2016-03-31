<?php
include '../../../config/config.php';
$service_title = '';
$service_status = '';
$service_image = '';
$service_details = '';
$service_id = '';
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
}
$sqlImage = "SELECT service_image FROM services WHERE service_id= $service_id";
$resultImage = mysqli_query($con, $sqlImage);
if ($resultImage) {
    while ($ImageObj = mysqli_fetch_object($resultImage)) {
        $service_image = $ImageObj->service_image;
    }
} else {
    if (DEBUG) {
        $error = "resultImage error: " . mysqli_error($con);
    } else {
        $error = "resultImage query failed.";
    }
}
if (isset($_POST['service_title'])) {
    extract($_POST);

    $service_title = validateInput($service_title);
    $service_details = validateInput($service_details);
    $service_status = validateInput($service_status);

    if (empty($service_title)) {
        $error = 'Service title required';
    } elseif (empty($service_details) || $service_details == '') {
        $error = "Service details required";
    } elseif (empty($service_status) || $service_status == '0') {
        $error = "Status required";
    } else {

        $sql_check = "SELECT * FROM services WHERE service_title='$service_title' AND service_id NOT IN (" . $service_id . ")";
        $result_check = mysqli_query($con, $sql_check);
        $count = mysqli_num_rows($result_check);
        if ($count >= 1) {
            $error = "Service already exists in record";
        } else {

            // image upload code
            if ($_FILES["service_image"]["tmp_name"] != '') {

                $service_image = basename($_FILES['service_image']['name']);
                $infoPath = pathinfo($service_image, PATHINFO_EXTENSION);
                $rename_image = 'SEIMG_' . date("YmdHis") . '.' . $infoPath;

                if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/service_image/')) {
                    mkdir($config['IMAGE_UPLOAD_PATH'] . '/service_image/', 0777, TRUE);
                }
                $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/service_image/' . $rename_image;

                $zebra = new Zebra_Image();
                $zebra->source_path = $_FILES["service_image"]["tmp_name"];
                $zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/service_image/' . $rename_image;

                if (!$zebra->resize(1200)) {
                    zebraImageErrorHandaling($zebra->error);
                }
            }
            $updatearray = '';
            $updatearray .= 'service_title = "' . $service_title . '" ';
            $updatearray .= ',service_details = "' . $service_details . '" ';
            if ($_FILES["service_image"]["tmp_name"] != '') {
                $updatearray .= ',service_image = "' . $rename_image . '"';
            }
            $updatearray .= ',service_status = "' . $service_status . '" ';
            $sql_update = "UPDATE services SET $updatearray WHERE service_id = $service_id";
            $result_update = mysqli_query($con, $sql_update);

            if ($sql_update) {
                $success = "Service information updated successfully";               
                $link = "list.php?success=" . base64_encode($success);
                redirect($link);
            } else {
                if (DEBUG) {
                    $error = "result_update query failed for " . mysqli_error($con);
                } else {
                    $error = "Something went wrong";
                }
            }
        }
    }
}

// getting all data
$sql_data = "SELECT * FROM services WHERE service_id = $service_id";
$result_data = mysqli_query($con, $sql_data);
if ($result_data) {
    $obj = mysqli_fetch_object($result_data);
    $service_title = $obj->service_title;
    $service_status = $obj->service_status;
    $service_details = $obj->service_details;
} else {
    $error = "Data not found";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include basePath('admin/header_script.php'); ?>

        <style>
            .example-modal .modal {
                position: relative;
                top: auto;
                bottom: auto;
                right: auto;
                left: auto;
                display: block;
                z-index: 1;
            }
            .example-modal .modal {
                background: transparent!important;
            }
        </style>
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php include basePath('admin/header.php'); ?>

            <aside class="main-sidebar">
                <?php include basePath('admin/site_menu.php'); ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Edit Service </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-newspaper-o"></i>&nbsp;Service  Settings</li>
                        <li class="active">Edit Service </li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="example-modal">
                                    <div class="modal">
                                        <div class="modal-dialog">
                                            <?php include basePath('admin/message.php'); ?>
                                            <div class="modal-content">
                                                <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>" />
                                                        <div class="form-group">
                                                            <label for="service_title">Service  Title&nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" id="service_title" name="service_title" value="<?php echo $service_title; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Service  Image<span style="color:red;">*</span></label>
                                                            <input type="file" name="service_image" id="service_image"/>
                                                        </div>
                                                        <div>
                                                            <img id="show_service_image" style="height: 70px; width: 80px;" src="../../../upload/service_image/<?php echo $service_image; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="service_details">Service  Details &nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <textarea id="service_details" name="service_details" rows="3" cols="30"><?php echo html_entity_decode($service_details, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Service Status&nbsp;&nbsp;<span style="color:red;">*</label>
                                                            <select id="service_status" name="service_status" class="form-control">
                                                                <option value="0">Select Status</option>
                                                                <option value="Active"
                                                                <?php
                                                                if ($service_status == 'Active') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Active
                                                                </option>
                                                                <option value="Inactive"<?php
                                                                if ($service_status == 'Inactive') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" id="btn_edit_service_news" name="btn_edit_service_news" class="btn btn-primary"><i class="fa fa-edit"></i> Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include basePath('admin/footer.php'); ?>
        </div>
        <script type="text/javascript">
            $("#serviceActive").addClass("active");
            $("#serviceActive").parent().parent().addClass("treeview active");
            $("#serviceActive").parent().addClass("in");
        </script>
        <script>
            $(document).ready(function () {
                $("#service_details").kendoEditor({
                    tools: [
                        "bold", "italic", "underline", "strikethrough", "justifyLeft", "justifyCenter", "justifyRight", "justifyFull",
                        "insertUnorderedList", "insertOrderedList", "indent", "outdent", "createLink", "unlink", "insertImage",
                        "insertFile", "subscript", "superscript", "createTable", "addRowAbove", "addRowBelow", "addColumnLeft",
                        "addColumnRight", "deleteRow", "deleteColumn", "viewHtml", "formatting", "cleanFormatting",
                        "fontName", "fontSize", "foreColor", "backColor"
                    ]
                });
            });
        </script>
        <?php include basePath('admin/footer_script.php'); ?>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#show_service_image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#service_image").change(function () {
                readURL(this);
            });
        </script>
    </body>
</html>