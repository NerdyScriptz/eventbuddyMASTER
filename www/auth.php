<?php
session_start();

function check_login() {
    // If the user is not logged in, redirect to login page
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
}
