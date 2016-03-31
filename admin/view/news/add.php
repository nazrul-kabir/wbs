<?php
include '../../../config/config.php';

$news_title = '';
$news_status = '';
$news_image = '';
$news_details = '';
$news_created_on = date('Y-m-d H:i:s');
$news_created_by = getSession('admin_id');
if (isset($_POST['btn_add_news'])) {
    extract($_POST);
   

    $news_title = validateInput($news_title);
    $news_details = validateInput($news_details);
    $news_status = validateInput($news_status);


    if (empty($news_title)) {
        $error = 'News title required';
    } elseif ($_FILES["news_image"]["tmp_name"] == '') {
        $error = 'Image required';
    } elseif (empty($news_details) || $news_details == '') {
        $error = "News  details required";
    } elseif (empty($news_status) || $news_status == '0') {
        $error = "Status required";
    } else {

        if ($_FILES["news_image"]["tmp_name"] != '') {

            $news_image = basename($_FILES['news_image']['name']);
            $infoPath = pathinfo($news_image, PATHINFO_EXTENSION);
            $rename_image = 'NEIMG_' . date("YmdHis") . '.' . $infoPath;

            if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/news_image/')) {
                mkdir($config['IMAGE_UPLOAD_PATH'] . '/news_image/', 0777, TRUE);
            }
            $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/news_image/' . $rename_image;

            $zebra = new Zebra_Image();
            $zebra->source_path = $_FILES["news_image"]["tmp_name"];
            $zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/news_image/' . $rename_image;

            if (!$zebra->resize(1200)) {
                zebraImageErrorHandaling($zebra->error);
            }
        }


        $insertarray = '';
        $insertarray .= 'news_title = "' . $news_title . '" ';
        $insertarray .= ',news_image = "' . $rename_image . '" ';
        $insertarray .= ',news_details = "' . $news_details . '" ';
        $insertarray .= ',news_status = "' . $news_status . '" ';
        $insertarray .= ',news_created_on = "' . $news_created_on . '" ';
        $insertarray .= ',news_created_by = "' . $news_created_by . '" ';

        $sql_insert = "INSERT INTO news SET $insertarray";
        $result_insert = mysqli_query($con, $sql_insert);

        if ($result_insert) {
            $success = "News inserted successfully";
            $news_title = '';
            $news_status = '';
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
                    <h1>Add News</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-newspaper-o"></i>&nbsp;News Settings</li>
                        <li class="active">Add News</li>
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
                                                            <label for="news_title">News Title&nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" id="news_title" name="news_title" value="<?php echo $news_title; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>News Image<span style="color:red;">*</span></label>
                                                            <input type="file" name="news_image" id="news_image"/>
                                                        </div>
                                                            
                                                        <div class="form-group">
                                                            <label for="news_details">News Details &nbsp;&nbsp;<span style="color:red;">*</span></label>
                                                            <textarea id="news_details" name="news_details" rows="3" cols="30"><?php echo html_entity_decode($news_details, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="news_status">News Status&nbsp;&nbsp;<span style="color:red;">*</label>
                                                            <select id="news_status" name="news_status" class="form-control">
                                                                <option value="0">Select Status</option>
                                                                <option value="Active"
                                                                <?php
                                                                if ($news_status == 'Active') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Active
                                                                </option>
                                                                <option value="Inactive"<?php
                                                                if ($news_status == 'Inactive') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" id="btn_add_news" name="btn_add_news" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
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
            $("#newsActive").addClass("active");
            $("#newsActive").parent().parent().addClass("treeview active");
            $("#newsActive").parent().addClass("in");
        </script>
        <script>
            $(document).ready(function () {
                $("#news_details").kendoEditor({
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
                        $('#show_news_image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#news_image").change(function () {
                readURL(this);
            });
        </script>
    </body>
</html>