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
if (!checkRequired(['id', 'pass'])) {
    header('Location: login.php?err=fillfields');
    return;
}

/**
 * @var string $id     Given user id
 * @var string $pass   Given user password
 */
$id   = $_REQUEST['id'];
$pass = $_REQUEST['pass'];

/** Check if the user is authenticated */
if (!checklogin($id, $pass)) {
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
$_SESSION['id']        = $id;

/** If remember is checked, set cookie for 30 days */
if (isset($_REQUEST['remember'])) {
    setcookie('usertoken', $_SESSION['usertoken'], time() + (3600 * 24 * 30), "/");
    setcookie('id', $_SESSION['id'], time() + (3600 * 24 * 30), "/");
}

/** @redirect home.php   User Home Page*/
header('Location: home.php');