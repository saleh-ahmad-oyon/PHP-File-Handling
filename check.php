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
if (!checkRequired(['id', 'pass', 'cpass', 'name', 'email', 'type'])) {
    header('Location: index.php?err=fillfields');
    return;
}

/**
 * @var array $registerdata
 *
 * @arrayindex string $registerdata['id']      ID of the user
 * @arrayindex string $registerdata['pass']    Password of the user
 * @arrayindex string $registerdata['name']    Name of the user
 * @arrayindex string $registerdata['email']   Email of the user
 * @arrayindex string $registerdata['type']    Type of the user
 */
$registerdata = [
    'id'    => $_REQUEST['id'],
    'pass'  => $_REQUEST['pass'],
    'name'  => $_REQUEST['name'],
    'email' => $_REQUEST['email'],
    'type'  => $_REQUEST['type'],
];

/** check the ID pattern */
if (!preg_match('/^\d{2}\-\d{5}\-\d{1}$/',$registerdata['id'])) {
    header('Location: index.php?err=iderror');
    return;
}

if (!checkUniqueID($registerdata['id'])) {
    header('Location: index.php?err=idexist');
    return;
}

/* check password and confirm password fileds are equal or not */
if ($registerdata['pass'] != $_REQUEST['cpass']) {
    header('Location: index.php?err=passwordmatch');
    return;
}

/**
 * check the password pattern
 * pattern: must be greated than 8 in length and contains a special character
 */
if (!preg_match('/(?=^.{9,}$)(?=.*[!@#$%^&*]+).*/', $registerdata['pass'])) {
    header('Location: index.php?err=validpass');
    return;
}

/* check the email pattern */
if (!filter_var($registerdata['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?err=email');
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
