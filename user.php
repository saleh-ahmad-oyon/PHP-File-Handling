<?php

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
}