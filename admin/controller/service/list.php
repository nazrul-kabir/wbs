<?php

include '../../../config/config.php';

$verb = $_SERVER["REQUEST_METHOD"];
header("Content-type: application/json");
if ($verb == "GET") {
    $service_array = array();
    $sql_service = "SELECT * FROM services ORDER BY service_id DESC";
    $result_service = mysqli_query($con, $sql_service);

    if ($result_service) {
        while ($row = mysqli_fetch_object($result_service)) {
            $service_array[] = $row;
        }
    } else {
        if (DEBUG) {
            $error = "result_service query failed for: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "result_service query failed.";
            echo json_encode($error);
        }
    }
    echo json_encode($service_array);
}


if ($verb == "POST") {

    extract($_POST);
    $arrayImage = array();
    $service_id = mysqli_real_escape_string($con, $service_id);
    $sqlImage = "SELECT service_image FROM services WHERE service_id = $service_id";
    $resultImage = mysqli_query($con, $sqlImage);
    if ($resultImage) {
        $arrayImage = mysqli_fetch_array($resultImage);
        unlink($config['IMAGE_UPLOAD_PATH'] . '/service_image/' . $arrayImage["service_image"]);
    } else {
        if (DEBUG) {
            $error = "resultImage error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "resultImage query failed";
            echo json_encode($error);
        }
    }
    $delete_sql = "DELETE FROM services WHERE service_id = $service_id";
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