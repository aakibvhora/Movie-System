<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

require_once ("mssql.php");
require_once("./siteCommon.php");

$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'mslogin.php';

displayPageHeader();

if(isset($_SESSION['userInfo'])){
    
    extract($_SESSION['userInfo']);
    if(isset($_GET['action'])){
        
        $action = $_GET['action'];
        $movieId = $_GET['movieId'];
        if($action =="Remove"){
            removeFromWatchList($userid, $movieId);
        }
        
    }
}
else // Otherwise, assign error message to $error
    {
        $error = 'Please login to view your watchlist';
        
    }
if (isset($error))
{
    echo '<div id="error" class="container"> <div class ="row row-content">' . $error . '</div></div>';
}
        $output = <<<STR
    <div class = "container">
        <br>
        <div class="row row-content"><!-- row -->
            
        
                <div class="col-xs-12 col-sm-12"><!-- widgets column left -->
                    <h2>$firstname's Watchlist</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Movie Name</th>
                                    <th>Summary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
STR;
                         
                                $movieList = getMoviesFromWatchList($userid);
                                
                                foreach ($movieList as $movie) {
                                    extract($movie);
                                    
                                    $output .= <<<STR
                                    <tr>
                                            <td><a href ="msmoviedetail.php?movieId='$movieId'" >$movietitle</a>
                                            <td>$summary</td>
                                            <td><a href ="mswatchlist.php?action=Remove&movieId=$movieId" class="btn btn-primary pull-right">Remove</a></td>
                                    </tr>
STR;
                                }
                            
                $output .= <<<STR
                            </tbody>    
                        </table>
                    </div>
                </div>
        </div>
    </div>
STR;
        echo $output;
displayPageFooter();