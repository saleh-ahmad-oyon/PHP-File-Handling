<?php
session_start();
if (!isset($_SESSION['usertoken'])) {
    header('Location: login.php');
}

require_once 'user.php';

$userinfo = getinfo($_SESSION['email']);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Edit Information</title>
</head>
<body>
<header>
    <h1>Edit your Information</h1>
</header>
<section>
    <form action="checkinfo.php" method="post">
        <table border="1">
            <tr>
                <td>
                    <label>First Name</label>
                </td>
                <td colspan="3">
                    <input type="text" name="fname" style="width: 100%" value="<?= $userinfo['fname'] ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Last Name</label>
                </td>
                <td colspan="3">
                    <input type="text" name="lname" style="width: 100%" value="<?= $userinfo['lname'] ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>DOB</label>
                </td>
                <td>
                    <select name="day" style="width: 100%">
                        <option value="" selected disabled>Day</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td>
                    <select name="month" style="width: 100%">
                        <option selected disabled>Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </td>
                <td>
                    <select name="year" style="width: 100%">
                        <option selected disabled>Year</option>
                        <?php for ($i = 1900; $i<=2002; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
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
                    <input type="radio" name="gender" value="female" />Female
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone</label>
                </td>
                <td colspan="3">
                    <input type="tel" name="phone" style="width: 100%" value="<?= $userinfo['phone'] ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Email ID</label>
                </td>
                <td colspan="3">
                    <input type="email" name="email" value="<?= $userinfo['email'] ?>" pattern="[([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)]i" title="Please insert a valid email" style="width: 100%" />
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
</section>
</body>
</html>
