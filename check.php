<?php
session_start();

/** Required Files */
require_once 'user.php';

/** check if the request came from signup page */
if (!isset($_REQUEST['signup'])) {
    header('Location: index.php');
    return;
}

/** check if the requested methos is post */
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: index.php');
    return;
}

/** store requested data on session */
$_SESSION['userdata'] = $_REQUEST;

/** check the required fields from the requested data */
if (!checkRequired(['fname', 'lname', 'day', 'month', 'year', 'gender', 'phone', 'email', 'pass', 'cpass'])) {
    header('Location: index.php?err=fillfields');
    return;
}

$propic = (!empty($_FILES) && isset($_FILES['profpic']) && $_FILES['profpic']['error'] != 4) ? $_FILES['profpic'] : false;

/** check if the requested data contains profile picture */
if (!$propic) {
    header('Location: index.php?err=proilepic');
    return;
}

/**
 * @var array $registerdata
 *
 * @arrayindex string $registerdata['fname']       First Name of the user
 * @arrayindex string $registerdata['lname']       Last Name of the user
 * @arrayindex int    $registerdata['day']         Day of Birth
 * @arrayindex string $registerdata['month']       Month of Birth
 * @arrayindex int    $registerdata['year']        Year of Birth
 * @arrayindex string $registerdata['gender']      Gender of the user
 * @arrayindex string $registerdata['phone']       Phone number of the user
 * @arrayindex string $registerdata['email']       Email of the user
 * @arrayindex string $registerdata['password']    Password of the user
 * @arrayindex string $registerdata['imgname']     Profile Image name of the user
 */
$registerdata = [
    'fname'     => $_REQUEST['fname'],
    'lname'     => $_REQUEST['lname'],
    'day'       => $_REQUEST['day'],
    'month'     => $_REQUEST['month'],
    'year'      => $_REQUEST['year'],
    'gender'    => $_REQUEST['gender'],
    'phone'     => $_REQUEST['phone'],
    'email'     => $_REQUEST['email'],
    'password'  => $_REQUEST['pass'],
    'imgname'   => $propic['name']
];

/** check the email pattern */
if (!filter_var($registerdata['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?err=email');
    return;
}

/** check if the email is used before */
if (!checkUniqueEmail($registerdata['email'])) {
    header('Location: index.php?err=emailexist');
    return;
}

/** check password and confirm password fileds are equal or not */
if ($registerdata['password'] != $_REQUEST['cpass']) {
    header('Location: index.php?err=passwordmatch');
    return;
}

/**
 * check the password pattern
 * pattern: must be greated than 8 in length and contains a special character
 */
if (!preg_match('/(?=^.{9,}$)(?=.*[!@#$%^&*]+).*/', $registerdata['password'])) {
    header('Location: index.php?err=validpass');
    return;
}

$target_dir    = 'profile_image/';
$target_file   = $target_dir . basename($propic['name']);
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$check = getimagesize($propic['tmp_name']);

/** check if the uploaded file is an image */
if (!$check) {
    header('Location: index.php?err=notimage');
    return;
}

/**
 * check if the size of the image is less than 500kb
 * Sizes are all based in bytes
 */
if ($propic["size"] > 500000) {
    header('Location: index.php?err=filesize');
    return;
}

/** check if the image extension is jpg/png/jpeg/gif */
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    header('Location: index.php?err=fileext');
    return;
}

/** if everything is ok, try to upload file */
if (!move_uploaded_file($propic["tmp_name"], $target_file)) {
    header('Location: index.php?err=uploaderror');
    return;
}

/** Store User Information to the file */
if (!storeinfo($registerdata)) {
    header('Location: index.php?err=storeerror');
    return;
}

/** Destroy $_SESSION['userdata'] where all requested data were stored */
unset($_SESSION['userdata']);

/** @redirect login.php   User Login Page*/
echo '<script language="javascript">
          alert("Successfully Registered !!");
          window.location="login.php";
      </script>';
