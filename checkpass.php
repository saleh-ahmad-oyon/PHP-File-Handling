<?php
session_start();

/** Required Files */
require_once 'user.php';

/** check if the request came from Password Change page */
if (!isset($_REQUEST['passchange'])) {
    header('Location: login.php');
    return;
}

/** check if the requested methos is post */
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: login.php');
    return;
}

/** check the required fields from the requested data */
if (!checkRequired(['oldpass', 'newpass', 'confnewpass'])) {
    header('Location: changepass.php?err=fillfields');
    return;
}

/**
 * @var string $oldpass         User old password
 * @var string $newpass         User new password
 * @var string $conirmnewpass   User new password
 */
$oldpass       = hash('sha256', $_REQUEST['oldpass']);
$newpass       = $_REQUEST['newpass'];
$conirmnewpass = $_REQUEST['confnewpass'];

/* check new password and confirm new password fileds are equal or not */
if ($newpass != $conirmnewpass) {
    header('Location: changepass.php?err=passwordmatch');
    return;
}

/** Update user password */
$error = updatePassword($oldpass, $newpass);
if ($error) {
    header('Location: changepass.php?err='.$error);
    return;
}

/** @redirect home.php   User Home Page*/
echo '<script language="javascript">
          alert("Successfully Changed Password !!");
          window.location="home.php";
      </script>';
