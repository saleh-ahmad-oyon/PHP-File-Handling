<?php

/** Resume existing session */
session_start();

/** Free all session variables */
session_unset();

/** Finally, destroy the session */
session_destroy();

/** destroy cookie if any cookie was set */
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach ($cookies as $cookie)
    {
        $parts = explode('=', $cookie);
        $name  = trim($parts[0]);

        setcookie($name, '', time() - 1000);
        setcookie($name, '', time() - 1000, '/');
    }
}

/** @redirect login.php     Login Page */
header('Location: login.php');
