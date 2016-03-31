<?php

/*
 * This function will return all row from a table 
 * Return type must me array or json
 * If return type is empty then data will show as an array
 * SQL hint: SELECT * FROM TABLE_NAME
 */

function SELECT_ALL($table_name, $return_type) {
    global $con;
    $query = "";
    if ($return_type == '') {
        $return_type = 'array';
    }

    if (!empty($table_name) && !empty($return_type)) {
        $query = "SELECT * FROM `$table_name`";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            $objects = array();
            if ($count >= 1) {
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }

                if ($return_type == "array") {
                    return $objects;
                } else if ($return_type == "json") {
                    $return_arr = array();
                    foreach ($objects as $obj) {
                        $push_arr = array();
                        foreach ($objects{0} as $key => $val) {
                            $push_arr["$key"] = utf8_encode($obj->{"$key"});
                        }
                        array_push($return_arr, $push_arr);
                    }
                    return json_encode($return_arr);
                } else {
                    return $objects;
                }
            }
        }
    }
}

/*
 * This function will return row based on unique id
 * Return type must be array or json
 * SQL hint: SELECT * FROM TABLE_NAME WHERE FIELD_ID = YOUR_ID
 */

function SELECT_ALL_BY_UNIQUE_ID($table_name, $return_type, $unique_id) {
    global $con;
    $query = "";
    if ($return_type == '') {
        $return_type = 'array';
    }
    if (!empty($table_name) && !empty($unique_id)) {
        $query = "SELECT * FROM `$table_name` WHERE  $unique_id";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            $objects = array();
            if ($count >= 1) {
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }

                if ($return_type == "array") {
                    return $objects;
                } else if ($return_type == "json") {
                    $return_arr = array();
                    foreach ($objects as $obj) {
                        $push_arr = array();
                        foreach ($objects{0} as $key => $val) {
                            $push_arr["$key"] = utf8_encode($obj->{"$key"});
                        }
                        array_push($return_arr, $push_arr);
                    }
                    return json_encode($return_arr);
                } else {
                    return $objects;
                }
            }
        }
    }
}

/*
 * This function will return row based on passing array
 * Return type must be array or json
 * SQL hint: SELECT * FROM TABLE_NAME WHERE FILED_1 = YOUR_VALUE_1 AND FIELD_2 = YOUR_VALUE_2 ...
 */

function SELECT_ALL_BY_STRING($table_name, $return_type, $string_array = '') {
    global $con;
    $query = "";

    if ($return_type == '') {
        $return_type = "array";
    }
    if (!empty($table_name) && !empty($string_array)) {
        if (count($string_array) >= 1) {
            $count = 0;
            $fields = '';
            foreach ($string_array as $col => $val) {
                if ($count++ != 0)
                    $fields .= ' AND ';
                $col = mysqli_real_escape_string($con, $col);
                $val = mysqli_real_escape_string($con, $val);
                $fields .= "`$col` = '$val'";
            }
        }

        $query = "SELECT * FROM `$table_name` WHERE $fields";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            $objects = array();
            if ($count >= 1) {
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }

                if ($return_type == "array") {
                    return $objects;
                } else if ($return_type == "json") {
                    $return_arr = array();
                    foreach ($objects as $obj) {
                        $push_arr = array();
                        foreach ($objects{0} as $key => $val) {
                            $push_arr["$key"] = utf8_encode($obj->{"$key"});
                        }
                        array_push($return_arr, $push_arr);
                    }
                    return json_encode($return_arr);
                } else {
                    return $objects;
                }
            } else {
                return 0;
            }
        }
    } else {
        return "Check all parameter";
    }
}

/*
 * This function will delete a row from table 
 * If this returns 1 then row deleted successfully
 * If this returns 0 then row not deleted. Check your sql.
 * SQL hint: DELETE FROM TABLE_NAME WHERE FIELD_ID = YOUR_ID 
 */

function DELETE_BY_ID($table_name, $condition) {
    global $con;
    $query = "";

    if (!empty($table_name) && !empty($condition)) {
        $return_type = 'array';
        $count_row = SELECT_ALL_BY_UNIQUE_ID($table_name, $return_type, $condition);
        if ($count_row >= 1) {
            $query = "DELETE FROM `$table_name` WHERE $condition";
            $result = mysqli_query($con, $query);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    } else {
        $error = 'Check all parameter';
        return $error;
    }
}

/*
 * This function will delete a row based on your passing array
 * First this will check whether row exists or not
 * If exists then delete successfully and returns 1
 * If not exists then this will return 0. Check your sql
 * SQL hint: DELETE FROM TABLE_NAME WHERE FIELD_1 = VALUE_1 AND FIELD_2 = VALUE_2 ...
 */

function DELETE_BY_STRING($table_name, $condition_array) {
    global $con;
    $query = "";

    if (!empty($table_name) && !empty($condition_array)) {
        $return_type = 'array';
        $count_row = SELECT_ALL_BY_STRING($table_name, $return_type, $condition_array);

        if ($count_row >= 1) {
            $count = 0;
            $fields = '';

            if (count($condition_array) >= 1) {
                foreach ($condition_array as $col => $val) {
                    if ($count++ != 0)
                        $fields .= ' AND ';
                    $col = mysqli_real_escape_string($con, $col);
                    $val = mysqli_real_escape_string($con, $val);
                    $fields .= "`$col` = '$val'";
                }
            }
            $query = "DELETE FROM `$table_name` WHERE $fields";
            $result = mysqli_query($con, $query);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    } else {
        $error = 'Check all parameter';
        return $error;
    }
}

/*
 * This function will return selected row or all row based on your query from table
 * You can also join perform joining query 
 * SQL hint: SELECT * FROM TABLE_NAME
 * SQL hint: SELECT * FROM TABLE_NAME WHERE FIELD_1 = VALUE_1
 * SQL hint: SELECT TABLE_1.*,TABLE_2.* FROM TABLE_1 LEFT JOIN TABLE_2 ON TABLE_1.TABLE_FIELD_1 = TABLE_2.TABLE_FIELD_2
 * SO ON ...
 * DO NOT PERFORM DELETE OPERATION
 * FOLLOW THE SQL HINT
 */

function RETURN_OBJECT_BY_QUERY($query, $return_type = '') {
    global $con;

    if ($return_type == '') {
        $return_type = 'array';
    }


    $result = mysqli_query($con, $query);
    $count_row = mysqli_num_rows($result);
    if ($count_row >= 1) {
        $objects = array();
        while ($rows = $result->fetch_object()) {
            $objects[] = $rows;
        }
        if (empty($return_type)) {
            return $objects;
        } elseif ($return_type == "array") {
            return $objects;
        } elseif ($return_type == "json") {
            $return_arr = array();
            foreach ($objects as $obj) {
                $push_arr = array();
                foreach ($objects{0} as $key => $val) {
                    $push_arr["$key"] = utf8_encode($obj->{"$key"});
                }
                array_push($return_arr, $push_arr);
            }
            return json_encode($return_arr);
        }
    } else {
        return 0;
    }
}

?>