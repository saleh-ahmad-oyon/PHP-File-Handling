<?php
session_start();

require_once 'user.php';

function checkRequired($fields)
{
    foreach ($fields as $field) {
        if (empty($_REQUEST[$field])) {
            return false;
        }
    }
    return true;
}

if (!isset($_REQUEST['edit-submit'])) {
    header('Location: index.php');
    return;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: index.php');
    return;
}

$_SESSION['userdata'] = $_REQUEST;

if (!checkRequired(['fname', 'lname', 'day', 'month', 'year', 'gender', 'phone'])) {
    header('Location: edit.php?err=fillfields');
    return;
}

$propic = (!empty($_FILES) && isset($_FILES['profpic']) && $_FILES['profpic']['error'] != 4) ? $_FILES['profpic'] : false;

$user['fname']  = $_REQUEST['fname'];
$user['lname']  = $_REQUEST['lname'];
$user['day']    = $_REQUEST['day'];
$user['month']  = $_REQUEST['month'];
$user['year']   = $_REQUEST['year'];
$user['gender'] = $_REQUEST['gender'];
$user['phone']  = $_REQUEST['phone'];
$user['email']  = $_REQUEST['email'];
$user['propic'] = $propic ? $propic['name'] : false;

if (!preg_match('/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/',$user['email'])) {
    header('Location: edit.php?err=email');
    return;
}

if ($propic) {
    $target_dir    = 'profile_image/';
    $target_file   = $target_dir . basename($propic['name']);
    $uploadOk      = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $check = getimagesize($propic['tmp_name']);

    if (!$check) {
        header('Location: edit.php?err=notimage');
        return;
    }

    if ($propic["size"] > 500000) {
        header('Location: edit.php?err=filesize');
        return;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        header('Location: edit.php?err=fileext');
        return;
    }

    if (!move_uploaded_file($propic["tmp_name"], $target_file)) {
        header('Location: edit.php?err=uploaderror');
        return;
    }
}

if (!updateInfo($user)) {
    header('Location: edit.php?err=updateerror');
    return;
}

unset($_SESSION['userdata']);

echo '<script language="javascript">
          alert("Successfully Updated your information !!");
          window.location="home.php";
      </script>';