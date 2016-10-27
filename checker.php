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

if (!isset($_REQUEST['u-login'])) {
    header('Location: login.php');
    return;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: login.php');
    return;
}

$_SESSION['logindata'] = $_REQUEST;

if (!checkRequired(['u-email', 'u-pass'])) {
    header('Location: login.php?err=fillfields');
    return;
}

$email = $_REQUEST['u-email'];
$pass  = hash('sha256', $_REQUEST['u-pass']);

$flag = false;

$myfile = fopen("record.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
    $user = explode('@#',fgets($myfile));

    $uemail = trim(explode('->', $user[5])[1]);
    $upass  = trim(explode('->', $user[7])[1]);

    if ($uemail == $email && $upass == $pass) {
        $flag = true;
        break;
    }
}
fclose($myfile);

if (!$flag) {
    header('Location: login.php?err=invaliddata');
    return;
}

unset($_SESSION['logindata']);

$_SESSION['usertoken'] = uniqid('', true);
$_SESSION['email']     = $email;

header('Location: home.php');