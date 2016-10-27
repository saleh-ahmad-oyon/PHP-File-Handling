<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
}

require_once 'user.php';

if (!getinfo($_SESSION['email'])) {
    die('An Error Occurred!!');
}
$userinfo = getinfo($_SESSION['email']);
$DOB      = explode('/', $userinfo['DOB']);
?>

<!doctype html>
<html lang="en">
<head>
    <title>Edit Information</title>
</head>
<body>
<header>
    <h1>Edit Your Information</h1>
</header>
<section>
    <form action="checkinfo.php" method="post" enctype="multipart/form-data">
        <table border="1">
            <tr>
                <td>
                    <label>First Name</label>
                </td>
                <td colspan="3">
                    <?php $fname = isset($_SESSION['userdata']['fname']) ? $_SESSION['userdata']['fname'] : $userinfo['fname']; ?>
                    <input type="text" name="fname" required style="width: 100%" value="<?= $fname ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Last Name</label>
                </td>
                <td colspan="3">
                    <?php $lname = isset($_SESSION['userdata']['lname']) ? $_SESSION['userdata']['lname'] : $userinfo['lname']; ?>
                    <input type="text" name="lname" required style="width: 100%" value="<?= $lname ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>DOB</label>
                </td>
                <td>
                    <?php $day = isset($_SESSION['userdata']['day']) ? $_SESSION['userdata']['day'] : $DOB[0]; ?>
                    <select name="day" required style="width: 100%">
                        <option value="" disabled>Day</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option <?= $day == $i ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td>
                    <?php $month = isset($_SESSION['userdata']['month']) ? $_SESSION['userdata']['month'] : $DOB[1]; ?>
                    <select name="month" required style="width: 100%">
                        <option disabled>Month</option>
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
                    <?php $year= isset($_SESSION['userdata']['year']) ? $_SESSION['userdata']['year'] : $DOB[2]; ?>
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
                    <?php $gender= isset($_SESSION['userdata']['gender']) ? $_SESSION['userdata']['gender'] : $userinfo['gender']; ?>
                    <input type="radio" name="gender" <?= $gender == 'female' ? 'checked' : '' ?> value="female" />Female
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone</label>
                </td>
                <td colspan="3">
                    <?php $phone = isset($_SESSION['userdata']['phone']) ? $_SESSION['userdata']['phone'] : $userinfo['phone']; ?>
                    <input type="tel" name="phone" required style="width: 100%" value="<?= $phone ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Email ID</label>
                </td>
                <td colspan="3">
                    <?php $email = isset($_SESSION['userdata']['email']) ? $_SESSION['userdata']['email'] : $userinfo['email']; ?>
                    <input type="email" name="email" required value="<?= $email ?>" pattern="[([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)]i" title="Please insert a valid email" style="width: 100%" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Proile Picture</label>
                </td>
                <td colspan="3">
                    <input type="file" name="profpic">
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">
                    <input type="submit" name="edit-submit" />
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
            case 'email':
                $error = 'Please insert a valid email.';
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
            case 'updateerror':
                $error = 'An error occured during saving your information.';
                break;
        }
        echo '<label>**'.$error.'</label>';
    }
    ?>
</section>
</body>
</html>
