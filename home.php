<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Home</title>
    </head>
    <body>
        <header>
            <h1>Welcome to the home page!!</h1>
        </header>
        <section>
            <a href="edit.php">Edit Info</a>&nbsp;&nbsp;
            <a href="changepass.php">Change Password</a>&nbsp;&nbsp;
            <a href="signout.php">Sign Out</a><br/>
        </section>
        <footer></footer>
    </body>
</html>