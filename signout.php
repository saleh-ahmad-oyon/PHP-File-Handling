<?php

/** Resume existing session */
session_start();

/** Free all session variables */
session_unset();

/** Finally, destroy the session */
session_destroy();

/** @redirect login.php     Login Page */
header('Location: login.php');
