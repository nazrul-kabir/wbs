<?php

include '../../../config/config.php';

$verb = $_SERVER["REQUEST_METHOD"];
header("Content-type: application/json");
if ($verb == "GET") {
    $news_array = array();
    $sql_news = "SELECT * FROM news ORDER BY news_id DESC";
    $result_news = mysqli_query($con, $sql_news);

    if ($result_news) {
        while ($row = mysqli_fetch_object($result_news)) {
            $news_array[] = $row;
        }
    } else {
        if (DEBUG) {
            $error = "result_news query failed for: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "result_news query failed.";
            echo json_encode($error);
        }
    }
    echo json_encode($news_array);
}


if ($verb == "POST") {

    extract($_POST);
    $arrayImage = array();
    $news_id = mysqli_real_escape_string($con, $news_id);
    $sqlImage = "SELECT news_image FROM news WHERE news_id = $news_id";
    $resultImage = mysqli_query($con, $sqlImage);
    if ($resultImage) {
        $arrayImage = mysqli_fetch_array($resultImage);
        unlink($config['IMAGE_UPLOAD_PATH'] . '/news_image/' . $arrayImage["news_image"]);
    } else {
        if (DEBUG) {
            $error = "resultImage error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "resultImage query failed";
            echo json_encode($error);
        }
    }
    $delete_sql = "DELETE FROM news WHERE news_id = $news_id";
    $result_delete = mysqli_query($con, $delete_sql);
    if ($result_delete) {
        echo json_encode($result_delete);
    } else {
        if (DEBUG) {
            $error = "result_delete error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "result_delete query failed.";
            echo json_encode($error);
        }
    }
}
?>