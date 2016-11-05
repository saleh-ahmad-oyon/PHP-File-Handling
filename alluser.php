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

if (!($userinfo = getinfo())) {
    die('An Error Occurred!!');
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Profile</title>
</head>
<body>
<header></header>
<section>
    <table border="1" style="border-collapse: collapse;">
        <tr>
            <th colspan="4" style="text-align: center;">Users</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>USER TYPE</th>
        </tr>
        <?php foreach ($userinfo as $user): ?>
        <tr>
            <td><?= $user['id']; ?></td>
            <td><?= $user['name']; ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['type']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" style="text-align: right">
                <a href="home.php">Go Home</a>
            </td>
        </tr>
    </table>
</section>
<footer></footer>
</body>
</html>
