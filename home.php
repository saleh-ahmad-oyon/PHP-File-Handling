<?php
session_start();

/** If cookie or session is not set redirect to login page */
if (!isset($_COOKIE['usertoken']) && !isset($_SESSION['usertoken'])) {
    header('Location: login.php');
    exit;
}

/** If session is not set assign the cookie value to the session */
if (!isset($_SESSION['usertoken'])) {
    $_SESSION['usertoken'] = $_COOKIE['usertoken'];
    $_SESSION['id']        = $_COOKIE['id'];
}

require_once 'user.php';

if (!($userinfo = getinfo($_SESSION['id']))) {
    die('An Error Occurred!!');
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Home</title>
    </head>
    <body style="display: inline-block;padding: 0 20px;text-align: center;border: 1px solid #000">
        <header>
            <h1>Welcome <?= $userinfo['name']; ?>!</h1>
        </header>
        <section>
            <a href="profile.php">Profile</a><br/>
            <a href="changepass.php">Change Password</a><br/>
            <?php if($userinfo['type'] == 'Admin'): ?>
            <a href="alluser.php">View Users</a><br/>
            <?php endif; ?>
            <a href="signout.php">Logout</a>
            <br/><br/><br/>
        </section>
        <footer></footer>
    </body>
</html>