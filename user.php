<?php

/**
 * Check required fields
 *
 * Check required fields from $_REQUEST
 *
 * @param  array $fields   $_REQUEST array elements
 *
 * @return bool
 */
function checkRequired($fields)
{
    foreach ($fields as $field) {
        if (empty($_REQUEST[$field])) {
            return false;
        }
    }
    return true;
}

/**
 * Store User Information
 *
 * Store user registration information to the file
 *
 * @param array $registerdata   requested data for registration
 *
 * @return bool
 */
function storeinfo($registerdata)
{
    if (!is_array($registerdata)) {
        return false;
    }

    $myfile = fopen("record.txt", "a") or die("Unable to open file!");
    $txt = "fname->".$registerdata['fname']."@#lname->".$registerdata['lname']
        ."@#DOB->".$registerdata['day']."/".$registerdata['month']."/".$registerdata['year']
        ."@#gender->".$registerdata['gender']."@#phone->".$registerdata['phone']."@#email->".$registerdata['email']
        ."@#profile_image->".$registerdata['imgname']."@#";
    fwrite($myfile, $txt);

    $hashpass = password_hash(base64_encode(hash('sha256', $registerdata['password'], true)), PASSWORD_DEFAULT);;

    $txt = "password->$hashpass\r\n";
    fwrite($myfile, $txt);
    fclose($myfile);

    return true;
}

/**
 * Check User Authentication
 *
 * Check if the user email and password are matched from the file
 *
 * @param string $email   User Email
 * @param string $pass    User password
 *
 * @return bool
 */
function checklogin($email, $pass)
{
    $flag = false;

    $myfile = fopen("record.txt", "r") or die("Unable to open file!");

    while(!feof($myfile)) {
        $user = explode('@#',fgets($myfile));

        $uemail = trim(explode('->', $user[5])[1]);
        $upass  = trim(explode('->', $user[7])[1]);

        if ($uemail == $email && password_verify(base64_encode(hash('sha256', $pass, true)), $upass)) {
            $flag = true;
            break;
        }
    }
    fclose($myfile);

    return $flag;
}

/**
 * Get User Information
 *
 * Get the user information from the file using user email
 *
 * @param string $email
 *
 * @return bool
 */
function getinfo($email)
{
    $myfile = file('record.txt');

    foreach ($myfile as $i => $data) {
        $user   = explode('@#',$data);
        $uemail = trim(explode('->', $user[5])[1]);

        if ($uemail == $email) {
            foreach ($user as $j => $u) {
                $userinfo[explode('->', $user[$j])[0]] = explode('->', $user[$j])[1];
            }
            return $userinfo;
        }
    }
    return false;
}

function updatePassword($oldpass, $newpass)
{
    $myfile = file('record.txt');
    $flag   = false;
    $error  = false;

    foreach ($myfile as $i => $data) {
        $user   = explode('@#',$data);

        $uemail = trim(explode('->', $user[5])[1]);

        if ($uemail == $_SESSION['email']) {
            $flag = true;

            foreach ($user as $j => $u) {
                $userinfo[explode('->', $user[$j])[0]] = explode('->', $user[$j])[1];
            }

            $userinfo['password'] = trim($userinfo['password']);

            /** Check if the old password is matched or not */
            if (password_verify(base64_encode(hash('sha256', $oldpass, true)), $userinfo['password'])) {
                header('Location: changepass.php?err=oldpassword');
                $error = 'oldpassword';
                break;
            }

            /**
             * check the password pattern
             * pattern: must be greated than 8 in length and contains a special character
             */
            if (!preg_match('/(?=^.{9,}$)(?=.*[!@#$%^&*]+).*/', $newpass)) {
                $error = 'validpass';
                break;
            }

            $hashpass   = password_hash(base64_encode(hash('sha256', $newpass, true)), PASSWORD_DEFAULT);;
            $myfile[$i] = str_replace($userinfo['password'], $hashpass, $data);

            break;
        }

        if ($flag) break;
    }
    file_put_contents('record.txt', implode('', $myfile));

    if (!$flag) {
        $error = 'updateerror';
    }

    return $error;
}

/**
 * Update User Information
 *
 * Update user information in the file using user email
 *
 * @param array $userdata   Modified user information
 *
 * @return bool
 */
function updateInfo($userdata)
{
    if (!is_array($userdata)) {
        return false;
    }

    $myfile = file('record.txt');
    $flag   = false;

    foreach ($myfile as $i => $data) {
        $user   = explode('@#',$data);

        $uemail = trim(explode('->', $user[5])[1]);

        if ($uemail == $_SESSION['email']) {
            $flag = true;

            foreach ($user as $j => $u) {
                $userinfo[explode('->', $user[$j])[0]] = explode('->', $user[$j])[1];
            }

            $DOB = [$userdata['day'], $userdata['month'], $userdata['year']];
            $dob = implode('/', $DOB);
            $pic = $userdata['propic'] ? $userdata['propic'] : $userinfo['profile_image'];

            $myfile[$i] = str_replace($userinfo['fname'], $userdata['fname'],
                str_replace($userinfo['lname'], $userdata['lname'],
                    str_replace($userinfo['DOB'], $dob,
                        str_replace($userinfo['gender'], $userdata['gender'],
                            str_replace($userinfo['phone'], $userdata['phone'],
                                str_replace($userinfo['email'], $userdata['email'],
                                    str_replace($userinfo['profile_image'], $pic, $data)))))));

            break;
        }

        if ($flag) break;
    }
    file_put_contents('record.txt', implode('', $myfile));

    $_SESSION['email'] = $userdata['email'];

    return $flag ? true : false;
}