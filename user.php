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

    $hashpass = hash('sha256', $registerdata['password']);

    $txt = "password->$hashpass\r\n";
    fwrite($myfile, $txt);
    fclose($myfile);
}

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