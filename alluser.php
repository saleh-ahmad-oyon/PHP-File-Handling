<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
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
