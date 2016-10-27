<?php
session_start();

function checkRequired($fields)
{
    foreach ($fields as $field) {
        if (empty($_REQUEST[$field])) {
            return false;
        }
    }
    return true;
}

if (!isset($_REQUEST['signup'])) {
    header('Location: index.php');
    return;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: index.php');
    return;
}

$_SESSION['userdata'] = $_REQUEST;

if (!checkRequired(['fname', 'lname', 'day', 'month', 'year', 'gender', 'phone', 'email', 'pass', 'cpass'])) {
    header('Location: index.php?err=fillfields');
    return;
}

$propic = (!empty($_FILES) && isset($_FILES['profpic']) && $_FILES['profpic']['error'] != 4) ? $_FILES['profpic'] : false;

if (!$propic) {
    header('Location: index.php?err=proilepic');
    return;
}

$fname     = $_REQUEST['fname'];
$lname     = $_REQUEST['lname'];
$day       = $_REQUEST['day'];
$month     = $_REQUEST['month'];
$year      = $_REQUEST['year'];
$gender    = $_REQUEST['gender'];
$phone     = $_REQUEST['phone'];
$email     = $_REQUEST['email'];
$password  = $_REQUEST['pass'];
$cpassword = $_REQUEST['cpass'];
$imgname   = $propic['name'];

if (!preg_match('/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/',$email)) {
    header('Location: index.php?err=email');
    return;
}

if ($password != $cpassword) {
    header('Location: index.php?err=passwordmatch');
    return;
}

if (!preg_match('/(?=^.{9,}$)(?=.*[!@#$%^&*]+).*/', $password)) {
    header('Location: index.php?err=validpass');
    return;
}

$target_dir    = 'profile_image/';
$target_file   = $target_dir . basename($propic['name']);
$uploadOk      = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$check = getimagesize($propic['tmp_name']);

if (!$check) {
    header('Location: index.php?err=notimage');
    return;
}

if ($propic["size"] > 500000) {
    header('Location: index.php?err=filesize');
    return;
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    header('Location: index.php?err=fileext');
    return;
}

if (!move_uploaded_file($propic["tmp_name"], $target_file)) {
    header('Location: index.php?err=uploaderror');
    return;
}

$myfile = fopen("record.txt", "a") or die("Unable to open file!");
$txt = "fname->$fname@#lname->$lname@#DOB->$day/$month/$year@#gender->$gender@#"
."phone->$phone@#email->$email@#profile_image->$imgname@#";
fwrite($myfile, $txt);

$hashpass = hash('sha256', $password);

$txt = "password->$hashpass\r\n";
fwrite($myfile, $txt);
fclose($myfile);
unset($_SESSION['userdata']);

echo '<script language="javascript">
          alert("Successfully Registered !!");
          window.location="login.php";
      </script>';
