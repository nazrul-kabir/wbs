<?php

/* change when upload to different domain 
 * setting site hosting  data 
 */

$host = $_SERVER['HTTP_HOST'];

$domain = str_replace('www.', '', str_replace('http://', '', $host));

if ($domain == 'arkhairul.com') {
    $config['SITE_NAME'] = 'WATER BOND SHIPYARD ';
    $config['ADMIN_SITE_NAME'] = 'WBS | ADMIN PANEL';
    $config['BASE_URL'] = 'http://arkhairul.com/ibfb/';
    $config['ROOT_DIR'] = '/home/arkhairul/public_html/ibfb/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'arkhairu_wbs';
    $config['DB_USER'] = 'arkhairu_lila';
    $config['DB_PASSWORD'] = 'Pandora*12015';
} elseif ($domain == '192.168.0.102') {
    $config['SITE_NAME'] = 'WATER BOND SHIPYARD ';
    $config['ADMIN_SITE_NAME'] = 'WBS | ADMIN PANEL';
    $config['BASE_URL'] = 'http://192.168.0.105/ibfb/';
    $config['ROOT_DIR'] = '/shipyard/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'wbs';
    $config['DB_USER'] = 'root';
    $config['DB_PASSWORD'] = '';
} else {
    $config['SITE_NAME'] = 'WATER BOND SHIPYARD ';
    $config['ADMIN_SITE_NAME'] = 'WBS | ADMIN PANEL';
    $config['BASE_URL'] = 'http://localhost/shipyard/';
    $config['ROOT_DIR'] = '/shipyard/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'wbs';
    $config['DB_USER'] = 'root';
    $config['DB_PASSWORD'] = '';
}

date_default_timezone_set('Asia/Dhaka');
$config['MASTER_ADMIN_EMAIL'] = "khairul@eyhost.biz"; /* Developer */
$config['PASSWORD_KEY'] = "#WBS#"; /* If u want to change PASSWORD_KEY value first of all make the admin table empty */
$config['ADMIN_PASSWORD_LENGTH_MAX'] = 15; /* Max password length for admin user  */
$config['ADMIN_PASSWORD_LENGTH_MIN'] = 5; /* Min password length for admin user  */
$config['ADMIN_COOKIE_EXPIRE_DURATION'] = (60 * 60 * 24 * 30); /* Min password length for admin user  */


$config['IMAGE_UPLOAD_PATH'] = $config['BASE_DIR'] . '/upload'; /* Upload files go here */
$config['IMAGE_UPLOAD_URL'] = $config['BASE_URL'] . 'upload'; /* Upload link with this */


   