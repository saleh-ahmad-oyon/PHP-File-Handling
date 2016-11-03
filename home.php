<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
}

require_once 'user.php';

if (!($userinfo = getinfo($_SESSION['id']))) {
    die('An Error Occurred!!');
}
;
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
            <a href="#">View Users</a><br/>
            <?php endif; ?>
            <a href="signout.php">Logout</a>
            <br/><br/><br/>
        </section>
        <footer></footer>
    </body>
</html>