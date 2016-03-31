<?php
include '../../../config/config.php';

$service_title = '';
$service_status = '';
$service_image = '';
$service_details = '';
$service_created_on = date('Y-m-d H:i:s');
$service_created_by = getSession('admin_id');
if (isset($_POST['btn_add_service'])) {
    extract($_POST);
   

    $service_title = validateInput($service_title);
    $service_details = validateInput($service_details);
    $service_status = validateInput($service_status);


    if (empty($service_title)) {
        $error = 'Service title required';
    } elseif ($_FILES["service_image"]["tmp_name"] == '') {
        $error = 'Image required';
    } elseif (empty($service_details) || $service_details == '') {
        $error = "Service  details required";
    } elseif (empty($service_status) || $service_status == '0') {
        $error = "Status required";
    } else {

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


        $insertarray = '';
        $insertarray .= 'service_title = "' . $service_title . '" ';
        $insertarray .= ',service_image = "' . $rename_image . '" ';
        $insertarray .= ',service_details = "' . $service_details . '" ';
        $insertarray .= ',service_status = "' . $service_status . '" ';
        $insertarray .= ',service_created_on = "' . $service_created_on . '" ';
        $insertarray .= ',service_created_by = "' . $service_created_by . '" ';

        $sql_insert = "INSERT INTO services SET $insertarray";
        $result_insert = mysqli_query($con, $sql_insert);

        if ($result_insert) {
            $success = "Service inserted successfully";
            $service_title = '';
            $service_status = '';
            $link = "list.php?success=" . base64_encode($success);
            redirect($link);
        } else {
            if (DEBUG) {
                echo $error = "result_insert query failed for " . mysqli_error($con);
            } else {
                $error = "Something went wrong!";
            }
        }
    }
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
                    <h1>Add Service</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-newspaper-o"></i>&nbsp;Service Settings</li>
                        <li class="active">Add Service</li>
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
                                                        <div class="form-group">
                                                            <label for="service_title">Service Title&nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" id="service_title" name="service_title" value="<?php echo $service_title; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Service Image<span style="color:red;">*</span></label>
                                                            <input type="file" name="service_image" id="service_image"/>
                                                        </div>
                                                            
                                                        <div class="form-group">
                                                            <label for="service_details">Service Details &nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <textarea id="service_details" name="service_details" rows="3" cols="30"><?php echo html_entity_decode($service_details, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="service_status">Service Status&nbsp;&nbsp;<span style="color:red;">*</label>
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
                                                        <button type="submit" id="btn_add_service" name="btn_add_service" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
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