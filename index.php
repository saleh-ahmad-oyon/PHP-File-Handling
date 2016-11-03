<?php session_start(); ?>
<!doctype html>
<html lang="en">
    <head>
        <title>Welcome</title>
    </head>
    <body>
        <header></header>
        <section>
            <form action="check.php" method="post" autocomplete="off">
                <fieldset style="display: inline-block;">
                    <legend><h4>REGISTRATION</h4></legend>

                    <?php $id = isset($_SESSION['userdata']['id']) ? $_SESSION['userdata']['id'] : ''; ?>
                    <label>Id</label><br />
                    <input type="text" name="id" value="<?= $id ?>" /><br/>

                    <?php $pass = isset($_SESSION['userdata']['pass']) ? $_SESSION['userdata']['pass'] : ''; ?>
                    <label>Password</label><br/>
                    <input type="password" name="pass" value="<?= $pass ?>" /><br/>

                    <?php $cpass = isset($_SESSION['userdata']['cpass']) ? $_SESSION['userdata']['cpass'] : ''; ?>
                    <label>Confirm Password</label><br/>
                    <input type="password" name="cpass" value="<?= $cpass ?>" /><br/>

                    <?php $name = isset($_SESSION['userdata']['name']) ? $_SESSION['userdata']['name'] : ''; ?>
                    <label>Name</label><br />
                    <input type="text" name="name" value="<?= $name ?>" /><br/>

                    <?php $email = isset($_SESSION['userdata']['email']) ? $_SESSION['userdata']['email'] : ''; ?>
                    <label>Email</label><br/>
                    <input type="email" name="email" value="<?= $email ?>" /><br/>

                    <?php $type = isset($_SESSION['userdata']['type']) ? $_SESSION['userdata']['type'] : ''; ?>
                    <label>User Type <i>[User/Admin]</i></label><br/>
                    <select name="type">
                        <option selected value="user">User</option>
                        <option <?= $type == 'admin' ? 'selected' : ''; ?> value="admin">Admin</option>
                    </select>

                    <hr/>

                    <input type="submit" value="Register" name="signup" />

                    <a href="login.php">Login</a>
                </fieldset>
            </form>
            <?php
            if (isset($_GET['err'])) {
                switch ($_GET['err']) {
                    case 'fillfields':
                        $error = 'All fields must be filled.';
                        break;
                    case 'iderror':
                        $error = 'Please enter a valid ID.';
                        break;
                    case 'email':
                        $error = 'Please insert a valid email.';
                        break;
                    case 'passwordmatch':
                        $error = 'Both password fields must be matched.';
                        break;
                    case 'validpass':
                        $error = 'The password fields must contain one Special Character and greater than 8 char in length.';
                        break;
                    case 'storeerror':
                        $error = 'An error occurred.';
                        break;
                }
                echo '<label>**'.$error.'</label>';
            }
            ?>
        </section>
        <footer></footer>
    </body>
</html>