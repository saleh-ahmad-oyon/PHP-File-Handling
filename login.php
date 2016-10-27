<?php
session_start();
if (isset($_SESSION['usertoken'])) {
    header('Location: home.php');
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Welcome to Login</title>
    </head>
    <body>
        <header>
            <h1>Please Login to access your home page</h1>
        </header>
        <section>
            <form action="checker.php" method="post">
                <table border="1">
                    <tr>
                        <td>Email</td>
                        <?php $email = isset($_SESSION['logindata']['u-email']) ? $_SESSION['logindata']['u-email'] : ''; ?>
                        <td><input type="text" name="u-email" value="<?= $email ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <?php $pass = isset($_SESSION['logindata']['u-pass']) ? $_SESSION['logindata']['u-pass'] : ''; ?>
                        <td><input type="password" name="u-pass" value="<?= $pass ?>" required /></td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="2"><input type="submit" name="u-login" value="Login" /></td>
                    </tr>
                </table>
            </form>
            <?php
            if (isset($_GET['err'])) {
                switch ($_GET['err']) {
                    case 'fillfields':
                        $error = 'All fields must be filled.';
                        break;
                    case 'invaliddata':
                        $error = 'Provided email or password is wrong.';
                        break;
                }
                echo '<label>**'.$error.'</label>';
            }
            ?>
        </section>
        <footer></footer>
    </body>
</html>