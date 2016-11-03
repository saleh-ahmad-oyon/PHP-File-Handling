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
                <fieldset style="display: inline-block;">
                    <legend><h4>LOGIN</h4></legend>

                    <?php $id = isset($_SESSION['logindata']['id']) ? $_SESSION['logindata']['id'] : ''; ?>
                    <label>User Id</label><br/>
                    <input type="text" name="id" value="<?= $id ?>" /><br/>

                    <?php $pass = isset($_SESSION['logindata']['pass']) ? $_SESSION['logindata']['pass'] : ''; ?>
                    <label>Password</label><br/>
                    <input type="password" name="pass" value="<?= $pass ?>" /><br/><br/>

                    <input type="checkbox" name="remember" /> Remember Me
                    <hr/>

                    <input type="submit" name="u-login" value="Login" />

                    <a href="index.php">Register</a>
                </fieldset>
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