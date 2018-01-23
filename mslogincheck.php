<?php
/*
    Purpose: Login Status Check
    Date: March 2017
 */

// this script checks whether the user has been authenticated
// if the session array element, "userInfo" is not set,
// the user is redirected to the login page (d9loginform.php)

session_start();

if (!isset($_SESSION['userInfo']))
{
    $redirect = $_SERVER['PHP_SELF'];
    
    if (isset($_GET['movieid']) && is_numeric($_GET['movieid']))
    {
        $movieid = (int) $_GET['movieid'];
        $redirect .= '?movieid=' . $movieid;
    }
    header('location: home.php?redirect=' . $redirect);
    die();
}
?>
