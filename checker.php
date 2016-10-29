<?php
session_start();

/** Required Files */
require_once 'user.php';

/** check if the request came from login page */
if (!isset($_REQUEST['u-login'])) {
    header('Location: login.php');
    return;
}

/** check if the requested methos is post */
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: login.php');
    return;
}

/** store requested data on session */
$_SESSION['logindata'] = $_REQUEST;

/** check the required fields from the requested data */
if (!checkRequired(['u-email', 'u-pass'])) {
    header('Location: login.php?err=fillfields');
    return;
}

$email = $_REQUEST['u-email'];
$pass  = hash('sha256', $_REQUEST['u-pass']);

/** Check is the user is authenticated */
if (!checklogin($email, $pass)) {
    header('Location: login.php?err=invaliddata');
    return;
}

/** Destroy $_SESSION['logindata'] where all requested data were stored */
unset($_SESSION['logindata']);

/**
 * @var string $_SESSION['usertoken']   User Token
 * @var string $_SESSION['email']       User Email
 */
$_SESSION['usertoken'] = uniqid('', true);
$_SESSION['email']     = $email;

/** @redirect home.php   User Home Page*/
header('Location: home.php');