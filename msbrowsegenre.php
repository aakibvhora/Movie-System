<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

require_once ("mssql.php");
require_once("./siteCommon.php");

$redirect = 'msbrowse.php';

displayPageHeader();

if(isset($_SESSION['userInfo'])){
    
    extract($_SESSION['userInfo']);
    
    
}

if(!isset($_GET['genreid']))
{
    $error = "No genre selected";
}
if (isset($error))
{
    header('location: home.php?redirect=' . $redirect);
    die();
}
$genreid = $_GET['genreid'];
$genretype = $_GET['genretype'];
$output = <<<STR
    <div class ="container">
        <div class="row row-content"><!-- row -->
            
        
                <div class="col-xs-12 col-sm-12"><!-- widgets column left -->
                    <h2>Movies related to $genretype</h2><br />
                    <div class="table-responsive">
                        <table class="table table-striped genrelist">
                     
                                
                        
STR;

                $movielist = getMoviesByGenre($genreid);
                if(count($movielist)== 0){
                    $output .= "<caption>Oops! There are currently no movies listed for thie genre.</caption>";
                }
               
                foreach ($movielist as $movie){
                    
                    extract($movie);
                    
                    $output .= <<<STR
                                    <tr>
                                            <td><a href ="msmoviedetail.php?movieId='$movieid'" >$movietitle</a></td>
                                            <td>$summary</td>
                                    </tr>
STR;
                }
$output .= <<<STR
                        </table>
                    </div>
                </div>
            
        </div>
    </div>
STR;
echo $output;
displayPageFooter();