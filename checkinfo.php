<?php
session_start();

/** Required Files */
require_once 'user.php';

/** check if the request came from edit information page */
if (!isset($_REQUEST['edit-submit'])) {
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
if (!checkRequired(['fname', 'lname', 'day', 'month', 'year', 'gender', 'phone'])) {
    header('Location: edit.php?err=fillfields');
    return;
}

$propic = (!empty($_FILES) && isset($_FILES['profpic']) && $_FILES['profpic']['error'] != 4) ? $_FILES['profpic'] : false;

/**
 * @var array $user
 *
 * @arrayindex string $user['fname']       First Name of the user
 * @arrayindex string $user['lname']       Last Name of the user
 * @arrayindex int    $user['day']         Day of Birth
 * @arrayindex string $user['month']       Month of Birth
 * @arrayindex int    $user['year']        Year of Birth
 * @arrayindex string $user['gender']      Gender of the user
 * @arrayindex string $user['phone']       Phone number of the user
 * @arrayindex string $user['email']       Email of the user
 * @arrayindex string $user['propic']      Profile Image name of the user
 */
$user = [
    'fname'  => $_REQUEST['fname'],
    'lname'  => $_REQUEST['lname'],
    'day'    => $_REQUEST['day'],
    'month'  => $_REQUEST['month'],
    'year'   => $_REQUEST['year'],
    'gender' => $_REQUEST['gender'],
    'phone'  => $_REQUEST['phone'],
    'email'  => $_REQUEST['email'],
    'propic' => $propic ? $propic['name'] : false
];

/* check the email pattern */
if (!preg_match('/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/',$user['email'])) {
    header('Location: edit.php?err=email');
    return;
}

/** check if the requested data contains profile picture */
if ($propic) {
    $target_dir    = 'profile_image/';
    $target_file   = $target_dir . basename($propic['name']);
    $uploadOk      = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $check = getimagesize($propic['tmp_name']);

    /** check if the uploaded file is an image */
    if (!$check) {
        header('Location: edit.php?err=notimage');
        return;
    }

    /**
     * check if the size of the image is less than 500kb
     * Sizes are all based in bytes
     */
    if ($propic["size"] > 500000) {
        header('Location: edit.php?err=filesize');
        return;
    }

    /** check if the image extension is jpg/png/jpeg/gif */
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        header('Location: edit.php?err=fileext');
        return;
    }

    /** if everything is ok, try to upload file */
    if (!move_uploaded_file($propic["tmp_name"], $target_file)) {
        header('Location: edit.php?err=uploaderror');
        return;
    }
}

/** if everything is ok, try to update user information */
if (!updateInfo($user)) {
    header('Location: edit.php?err=updateerror');
    return;
}

/** Destroy $_SESSION['userdata'] where all requested data were stored */
unset($_SESSION['userdata']);

/** @redirect home.php   User home Page*/
echo '<script language="javascript">
          alert("Successfully Updated your information !!");
          window.location="home.php";
      </script>';