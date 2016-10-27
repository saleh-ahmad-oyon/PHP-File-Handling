<?php

session_start();
unset($_SESSION['usertoken']);
session_unset();
header('Location: login.php');
