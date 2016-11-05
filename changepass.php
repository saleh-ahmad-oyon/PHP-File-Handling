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
                <fieldset style="display: inline-block;">
                    <legend><h4>CHANGE PASSWORD</h4></legend>

                    <?php $cpass = isset($_SESSION['userpass']['currentpass']) ? $_SESSION['userpass']['currentpass'] : ''; ?>
                    <label>Current Password</label><br/>
                    <input type="password" name="currentpass" value="<?= $cpass ?>" /><br/>

                    <?php $npass = isset($_SESSION['userpass']['newpass']) ? $_SESSION['userpass']['newpass'] : ''; ?>
                    <label>New Password</label><br/>
                    <input type="password" name="newpass" value="<?= $npass ?>" /><br/>

                    <?php $rnpass = isset($_SESSION['userpass']['renewpass']) ? $_SESSION['userpass']['renewpass'] : ''; ?>
                    <label>Retype New Password</label><br/>
                    <input type="password" name="renewpass" value="<?= $rnpass ?>" />

                    <hr/>

                    <input type="submit" value="Change" name="passchange" />
                    <a href="home.php">Home</a>
                </fieldset>
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
                    case 'updateerror':
                        $error = 'An error occurred.';
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
