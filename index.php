<?php session_start(); ?>
<!doctype html>
<html lang="en">
    <head>
        <title>Welcome</title>
    </head>
    <body>
        <header>
            <h1>
                Please Sign Up
            </h1>
        </header>
        <section>
            <form action="check.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <table border="1">
                    <tr>
                        <td>
                            <label>First Name</label>
                        </td>
                        <td colspan="3">
                            <?php $fname = isset($_SESSION['userdata']['fname']) ? $_SESSION['userdata']['fname'] : ''; ?>
                            <input type="text" name="fname" required value="<?= $fname ?>" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Last Name</label>
                        </td>
                        <td colspan="3">
                            <?php $lname = isset($_SESSION['userdata']['lname']) ? $_SESSION['userdata']['lname'] : ''; ?>
                            <input type="text" name="lname" required value="<?= $lname ?>" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>DOB</label>
                        </td>
                        <td>
                            <?php $day = isset($_SESSION['userdata']['day']) ? $_SESSION['userdata']['day'] : ''; ?>
                            <select name="day" style="width: 100%" required>
                                <option value="" selected disabled>Day</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                     <option <?= $day == $i ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td>
                            <?php $month = isset($_SESSION['userdata']['month']) ? $_SESSION['userdata']['month'] : ''; ?>
                            <select name="month" required style="width: 100%">
                                <option selected disabled>Month</option>
                                <option <?= $month == 'January' ? 'selected' : '' ?> value="January">January</option>
                                <option <?= $month == 'February' ? 'selected' : '' ?> value="February">February</option>
                                <option <?= $month == 'March' ? 'selected' : '' ?> value="March">March</option>
                                <option <?= $month == 'April' ? 'selected' : '' ?> value="April">April</option>
                                <option <?= $month == 'May' ? 'selected' : '' ?> value="May">May</option>
                                <option <?= $month == 'June' ? 'selected' : '' ?> value="June">June</option>
                                <option <?= $month == 'July' ? 'selected' : '' ?> value="July">July</option>
                                <option <?= $month == 'August' ? 'selected' : '' ?> value="August">August</option>
                                <option <?= $month == 'September' ? 'selected' : '' ?> value="September">September</option>
                                <option <?= $month == 'October' ? 'selected' : '' ?> value="October">October</option>
                                <option <?= $month == 'November' ? 'selected' : '' ?> value="November">November</option>
                                <option <?= $month == 'December' ? 'selected' : '' ?> value="December">December</option>
                            </select>
                        </td>
                        <td>
                            <?php $year= isset($_SESSION['userdata']['year']) ? $_SESSION['userdata']['year'] : ''; ?>
                            <select name="year" required style="width: 100%">
                                <option selected disabled>Year</option>
                                <?php for ($i = 1900; $i<=2002; $i++): ?>
                                    <option <?= $year == $i ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <label>Gender</label>
                        </td>
                        <td colspan="3">
                            <input type="radio" name="gender" value="male" checked />Male
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php $gender= isset($_SESSION['userdata']['gender']) ? $_SESSION['userdata']['gender'] : ''; ?>
                            <input type="radio" name="gender" <?= $gender == 'female' ? 'checked' : '' ?> value="female" />Female
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Phone</label>
                        </td>
                        <td colspan="3">
                            <?php $phone = isset($_SESSION['userdata']['phone']) ? $_SESSION['userdata']['phone'] : ''; ?>
                            <input type="tel" required value="<?= $phone ?>" name="phone" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Email ID</label>
                        </td>
                        <td colspan="3">
                            <?php $email = isset($_SESSION['userdata']['email']) ? $_SESSION['userdata']['email'] : ''; ?>
                            <input type="email" required value="<?= $email ?>" name="email" pattern="[([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)]i" title="Please insert a valid email" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password</label>
                        </td>
                        <td colspan="3">
                            <?php $pass = isset($_SESSION['userdata']['pass']) ? $_SESSION['userdata']['pass'] : ''; ?>
                            <input type="password" required value="<?= $pass ?>" name="pass" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Confirm Password</label>
                        </td>
                        <td colspan="3">
                            <?php $cpass = isset($_SESSION['userdata']['cpass']) ? $_SESSION['userdata']['cpass'] : ''; ?>
                            <input type="password" required value="<?= $cpass ?>" name="cpass" style="width: 100%" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Proile Picture</label>
                        </td>
                        <td colspan="3">
                            <input type="file" required name="profpic">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center">
                            <input type="submit" value="Sign Up" name="signup" />
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
                    case 'proilepic':
                        $error = 'You have to upload your proile picture.';
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
                    case 'notimage':
                        $error = 'Your uploaded file is not an image.';
                        break;
                    case 'filesize':
                        $error = 'Your uploaded file is too large.';
                        break;
                    case 'fileext':
                        $error = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
                        break;
                    case 'uploaderror':
                        $error = 'Sorry, there was an error uploading your file.';
                        break;
                }
                echo '<label>**'.$error.'</label>';
            }
            ?>
            <br/><br/>
            <label>Already a member? Click <a href="login.php">here</a> to login</label>
        </section>
        <footer></footer>
    </body>
</html>