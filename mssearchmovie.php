<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

require_once ("mssql.php");
require_once("./siteCommon.php");

$redirect = 'mssearch.php';
$genreid = $_GET['genreid'];
$movietitle = $_GET['movietitle'];
$genretype=getGenreType($genreid);

// remove any potentially malicious characters

$movietitle = trim($movietitle);




//if($genreid=="" && $movietitle=="")
//{
//    $error = "No genre selected";
//}
if (isset($error))
{
    header('location: mssearch.php?redirect=' . $redirect);
    die();
}
displayPageHeader();

if(isset($_SESSION['userInfo'])){
    
    extract($_SESSION['userInfo']);
}

$output = <<<STR
    <div class ="container">
        <div class="row row-content"><!-- row -->
            
        
                <div class="col-xs-12 col-sm-12"><!-- widgets column left -->
                    <h2>You search movies related to... <br />Genre : $genretype <br /> Movie Title : $movietitle</h2><br />
                    <div class="table-responsive">
                        <table class="table table-striped genrelist">
                        
STR;

                $movielist = getMoviesByMultiCriteria($genreid,$movietitle);
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