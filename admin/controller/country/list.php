<?php

include '../../../config/config.php';

header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
if ($verb == "GET") {
    $arrCountry = array();
    $sqlCountry = "SELECT * FROM country ORDER BY country_id DESC";
    $resultCountry = mysqli_query($con, $sqlCountry);
    if ($resultCountry) {
        while ($objCountry = mysqli_fetch_object($resultCountry)) {
            $arrCountry[] = $objCountry;
        }
    } else {
        if (DEBUG) {
            $error = "resultCountry error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "resultCountry query failed";
            echo json_encode($error);
        }
    }
    echo "{\"data\":" . json_encode($arrCountry) . "}";
}


if ($verb == "PUT") {
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $country_name = mysqli_real_escape_string($con, $request_vars["country_name"]);

    $insertCountryArray = '';
    $insertCountryArray .=' country_name = "' . $country_name . '"';


    $runInsertCountryArray = "INSERT INTO country SET $insertCountryArray";
    $resultCountryArray = mysqli_query($con, $runInsertCountryArray);

    if ($resultCountryArray) {
        $country_id = mysqli_insert_id($con);
        echo "" . $country_id . "";
    } else {
        if (DEBUG) {
            $error = "resultCountryArray error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "resultCountryArray query failed";
            echo json_encode($error);
        }
    }
}

if ($verb == "POST") {

    $country_id = mysqli_real_escape_string($con, $_POST["country_id"]);
    $country_name = mysqli_real_escape_string($con, $_POST["country_name"]);

    $updateCountryArray = '';
    $updateCountryArray .=' country_name = "' . $country_name . '"';

    $runUpdateCountryArray = "UPDATE country SET $updateCountryArray WHERE country_id = $country_id";

    $rsesultUpdateCountry = mysqli_query($con, $runUpdateCountryArray);

    if ($rsesultUpdateCountry) {
        echo json_encode($rsesultUpdateCountry);
    } else {
        if (DEBUG) {
            $error = "rsesultUpdateCountry error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "rsesultUpdateCountry query failed for Country ID: " . $country_id;
            echo json_encode($error);
        }
    }
}

if ($verb == "DELETE") {

    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $country_id = mysqli_real_escape_string($con, $request_vars["country_id"]);

    $deleteCountry = "DELETE FROM country WHERE country_id = '" . $country_id . "'";
    $resultDelete = mysqli_query($con, $deleteCountry);

    if ($resultDelete) {
        echo json_encode($resultDelete);
    } else {
        if (DEBUG) {
            $error = "resultDelete error: " . mysqli_error($con);
            echo json_encode($error);
        } else {
            $error = "resultDelete query failed for Country ID: " . $country_id;
            echo json_encode($error);
        }
    }
}
?>