<?php
include '../../../config/config.php';
$clients_name = '';
$clients_link = '';
$clients_status = '';
$clients_image = '';
$clients_updated_by = getSession('admin_id');
$clients_id = '';
if (isset($_GET['id'])) {
    $clients_id = $_GET['id'];
}

if (isset($_POST['clients_name'])) {
    extract($_POST);

    $clients_name = validateInput($clients_name);
    $clients_status = validateInput($clients_status);

    // check clients priority and exist
    $sql_check = "SELECT * FROM clients WHERE clients_name='$clients_name' AND clients_id NOT IN (" . $clients_id . ")";
    $result_check = mysqli_query($con, $sql_check);
    $count = mysqli_num_rows($result_check);
    if ($count > 0) {
        $error = "Clients already exists in record";
    } else {
        if ($_FILES["clients_image"]["tmp_name"] != '') {

            $clients_image = basename($_FILES['clients_image']['name']);
            $infoPath = pathinfo($clients_image, PATHINFO_EXTENSION);
            $rename_image = 'PIMG_' . date("YmdHis") . '.' . $infoPath;

            if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/clients_image/')) {
                mkdir($config['IMAGE_UPLOAD_PATH'] . '/clients_image/', 0777, TRUE);
            }
            $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/clients_image/' . $rename_image;

            $zebra = new Zebra_Image();
            $zebra->source_path = $_FILES["clients_image"]["tmp_name"];
            $zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/clients_image/' . $rename_image;

            if (!$zebra->resize(400)) {
                zebraImageErrorHandaling($zebra->error);
            }
        }
        $custom_array = '';
        $custom_array .= 'clients_name = "' . $clients_name . '"';
        if ($_FILES["clients_image"]["tmp_name"] != '') {
            $custom_array .= ',clients_image = "' . $rename_image . '"';
        }
        $custom_array .= ',clients_status = "' . $clients_status . '"';
        $custom_array .= ',clients_link = "' . $clients_link . '"';
        $custom_array .= ',clients_updated_by = "' . $clients_updated_by . '"';

        $sql = "UPDATE clients SET $custom_array WHERE clients_id = $clients_id";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $success = 'Clients information updated successfully';
            $link = "list.php?success=" . base64_encode($success);
            redirect($link);
        } else {
            if (DEBUG) {
                $error = 'result query failed for ' . mysqli_error($con);
            } else {
                $error = 'Something went wrong';
            }
        }
    }
}
$sqlImage = "SELECT clients_image FROM clients WHERE clients_id= $clients_id";
$resultImage = mysqli_query($con, $sqlImage);
if ($resultImage) {
    while ($ImageObj = mysqli_fetch_object($resultImage)) {
        $clients_image = $ImageObj->clients_image;
    }
} else {
    if (DEBUG) {
        $error = "resultImage error: " . mysqli_error($con);
    } else {
        $error = "resultImage query failed.";
    }
}
// getting clients data
$sqlData = "SELECT * FROM clients WHERE clients_id = $clients_id";
$resultData = mysqli_query($con, $sqlData);
if ($resultData) {
    $obj = mysqli_fetch_object($resultData);
    $clients_name = $obj->clients_name;
    $clients_status = $obj->clients_status;
    $clients_link = $obj->clients_link;
} else {
    
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
                    <h1>Edit Clients</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-laptop"></i>&nbsp;General Settings</li>
                        <li class="active">Edit Clients</li>
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
                                                <form method="POST" id="clientsForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="clients_id" name="clients_id" value="<?php echo $clients_id; ?>" />
                                                        <div class="form-group">
                                                            <label for="clients_name">Clients Name &nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" id="clients_name" name="clients_name" value="<?php echo $clients_name; ?>" required="required" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="clients_link">Clients Link &nbsp;&nbsp;<span style="color:red;">*</span>&nbsp;&nbsp;<span style="color: green;">example: http://www.abc.com</span></label>
                                                            <input type="text" class="form-control" id="clients_link" name="clients_link" value="<?php echo $clients_link; ?>" required="required" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="clients_image">Clients Image&nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="file" name="clients_image" id="clients_image" />
                                                        </div>
                                                        <div>
                                                            <img src="../../../upload/clients_image/<?php echo $clients_image; ?>" id="show_image" style="height: 70px; width: 80px;" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="clients_status">Clients Status&nbsp;&nbsp;<span style="color:red;">*</label>
                                                            <select id="clients_status" name="clients_status" class="form-control" required="required" />
                                                            <option value="0">Select Status</option>
                                                            <option value="Active"
                                                            <?php
                                                            if ($clients_status == 'Active') {
                                                                echo "selected";
                                                            }
                                                            ?>>Active
                                                            </option>
                                                            <option value="Inactive"<?php
                                                            if ($clients_status == 'Inactive') {
                                                                echo "selected";
                                                            }
                                                            ?>>Inactive
                                                            </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <p id="errorShow" style="display: none;background-color: #ea2e49;color: white; padding: 4px 4px 2px 4px;font-size: 12px;position: relative;">
                                                                Please fill up required (*) fields
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" id="btnSave" name="btnSave" class="btn btn-primary"><i class="fa fa-edit"></i> Update</button>
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
            $("#clientsActive").addClass("active");
            $("#clientsActive").parent().parent().addClass("treeview active");
            $("#clientsActive").parent().addClass("in");
        </script>
        <?php include basePath('admin/footer_script.php'); ?>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#show_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#clients_image").change(function () {
                readURL(this);
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#btnSave").click(function () {

                    var clients_name = $("#clients_name").val();
                    var clients_link = $("#clients_link").val();
                    var clients_status = $("#clients_status option:selected").val();
                    var status = 0;
                    if (clients_name == '') {
                        status++;
                        $("#errorShow").show();
                        $("#clients_name").css({
                            "border": "1px solid red"
                        });
                    }
                    if (clients_link == '') {
                        status++;
                        $("#errorShow").show();
                        $("#clients_link").css({
                            "border": "1px solid red"
                        });
                    }
                    if (clients_status == '0') {
                        status++;
                        $("#errorShow").show();
                        $("#clients_status").css({
                            "border": "1px solid red"
                        });
                    }
                    if (status == 0) {
                        $("#errorShow").hide();
                        $("#clientsForm").submit();
                    }
                });
            });
        </script>
    </body>
</html>