<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

// If filmpk is not passed with page request or it is not numeric, redirect to Home Page
// Else, assign the URL parameter to a variable

$listPage = 'mslogin.php';

if (!isset($_POST['movieId']))
{
    header('Refresh: 2; URL=' . $listPage);
    exit();
}
else
{
    $movieId = $_POST['movieId'];
}
// include files

require_once ("siteCommon.php");
require_once ("mssql.php");

if(isset($_SESSION['userInfo'])){
    
    extract($_SESSION['userInfo']);
}

$rating = $_POST['star'];
echo $userid."<br />";
echo $movieId."<br />";
echo $rating."<br />";
if(count(getMovieRating($userid, $movieId))== 1){
updateMovieRating($userid, $movieId, $rating);}
else{
insertMovieRating($userid, $movieId, $rating);}
header("Location:msmoviedetail.php?movieId='$movieId'");