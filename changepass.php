<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Change Password</title>
    </head>
    <body>
        <header>
            <h1>Change your password</h1>
        </header>
        <section>
            <form action="checkpass.php" method="post">
                <table border="1">
                    <tr>
                        <td>
                            <label>Old Password</label>
                        </td>
                        <td>
                            <input type="password" name="oldpass" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>New Password</label>
                        </td>
                        <td>
                            <input type="password" name="newpass" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Confirm New Password</label>
                        </td>
                        <td>
                            <input type="password" name="confnewpass" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center">
                            <input type="submit" name="passchange" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            if (isset($_GET['err'])) {
                switch ($_GET['err']) {
                    case 'fillfields':
                        $error = 'All fields must be filled.';
                        break;
                    case 'passwordmatch':
                        $error = 'Provided new password must be same.';
                        break;
                    case 'authentication':
                        $error = 'Authentication error.';
                        break;
                    case 'oldpassword':
                        $error = 'Provided old password is incorrect.';
                        break;
                    case 'validpass':
                        $error = 'The password fields must contain one Special Character and greater than 8 char in length.';
                        break;
                }
                echo '<label>**'.$error.'</label>';
            }
            ?>
        </section>
    </body>
</html>
