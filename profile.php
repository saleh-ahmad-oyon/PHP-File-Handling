<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
}

require_once 'user.php';

if (!($userinfo = getinfo($_SESSION['id']))) {
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
                    <th colspan="2" style="text-align: center;">Profile</th>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><?= $userinfo['id']; ?></td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td><?= $userinfo['name']; ?></td>
                </tr>
                <tr>
                    <td>EMAIL</td>
                    <td><?= $userinfo['email']; ?></td>
                </tr>
                <tr>
                    <td>USER TYPE</td>
                    <td><?= $userinfo['type']; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right">
                        <a href="home.php">Go Home</a>
                    </td>
                </tr>
            </table>
        </section>
        <footer></footer>
    </body>
</html>
