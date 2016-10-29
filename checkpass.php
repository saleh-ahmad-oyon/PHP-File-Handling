<?php
session_start();

/** Required Files */
require_once 'user.php';

if (!isset($_REQUEST['passchange'])) {
    header('Location: login.php');
    return;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: login.php');
    return;
}

if (!checkRequired(['oldpass', 'newpass', 'confnewpass'])) {
    header('Location: changepass.php?err=fillfields');
    return;
}

$oldpass       = hash('sha256', $_REQUEST['oldpass']);
$newpass       = $_REQUEST['newpass'];
$conirmnewpass = $_REQUEST['confnewpass'];

if ($newpass != $conirmnewpass) {
    header('Location: changepass.php?err=passwordmatch');
    return;
}

$myfile = file('record.txt');
$flag   = false;

foreach ($myfile as $i => $data) {
    $user   = explode('@#',$data);

    $uemail = trim(explode('->', $user[5])[1]);

    if ($uemail == $_SESSION['email']) {
        $flag = true;

        foreach ($user as $j => $u) {
            $userinfo[explode('->', $user[$j])[0]] = explode('->', $user[$j])[1];
        }

        $userinfo['password'] = trim($userinfo['password']);

        if ($userinfo['password'] != $oldpass) {
            header('Location: changepass.php?err=oldpassword');
            return;
        }

        if (!preg_match('/(?=^.{9,}$)(?=.*[!@#$%^&*]+).*/', $newpass)) {
            header('Location: changepass.php?err=validpass');
            return;
        }

        $hashpass = hash('sha256', $newpass);
        $myfile[$i] = str_replace($userinfo['password'], $hashpass, $data);
    }
}
file_put_contents('record.txt', implode('', $myfile));

if (!$flag) {
    header('Location: changepass.php?err=authentication');
    return;
}

echo '<script language="javascript">
          alert("Successfully Changed Password !!");
          window.location="home.php";
      </script>';
