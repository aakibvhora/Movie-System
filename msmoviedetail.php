<?php
/* 
    Date: January 2017
    Uses: siteCommon2.php, d10Sql.php
*/

session_start();

$listPage = 'mslogin.php';

// If filmpk is not passed with page request or it is not numeric, redirect to Home Page
// Else, assign the URL parameter to a variable

if (!isset($_GET['movieId']))
{
    header('Location:' . $listPage);
    exit();
}
else
{
    $movieId = $_GET['movieId'];
}
// include files

require_once ("siteCommon.php");
require_once ("mssql.php");
// get the movietitle associated with the filmpk
$movieRow = getMovieDetails($movieId);
if (count($movieRow) === 1){
extract($movieRow[0]);}
else
{
    header('Location:' . $listPage);
    exit();
}
// call the displayPageHeader method in siteCommon2.php



displayPageHeader();

$output = <<<STR
    <div class ="container">
        <div class="row row-content"><!-- row -->
            
        
                <div class="col-xs-12 col-sm-9"><!-- widgets column left -->
                    <h2>$MovieTitle
STR;
if(isset($_SESSION['userInfo'])){
    
    extract($_SESSION['userInfo']);
        $Rating = 0;
        $rating = getMovieRating($userid, $movieId);
        if(count($rating) == 1){
        extract($rating[0]);
        }
        
    if(isset($_GET['action'])){
        
        $action = $_GET['action'];
        
        if($action =="Add"){
            if(!isPresentInWatchList($userid, $movieId)){
            addToWatchList($userid, $movieId);
            }
            
        }
        else if($action =="Remove"){
            if(isPresentInWatchList($userid, $movieId)){
            removeFromWatchList($userid, $movieId);
            }
        }
        
    }
    
    
    if(!isPresentInWatchList($userid, $movieId)){
    $output .= <<<STR
    <a href = "msmoviedetail.php?action=Add&movieId='$movieId'" class="btn btn-primary pull-right">Add to Watchlist</a>
STR;
    }
    else{
        $output .= <<<STR
    <a href = "msmoviedetail.php?action=Remove&movieId='$movieId'" class="btn btn-primary pull-right">Delete From Watchlist</a>
STR;
    }
    
    
}
    $MovieGenreType = getGenreType($MovieGenre);
            $output .= <<<STR
                                </h2>
                    <h2><small> $MovieGenreType Movie</small> 
                    </h2>
                    
STR;
            
            if(isset($_SESSION['userInfo'])){
                      $output .= <<<STR
                        <br />
<h5>Rating: </h5>
            <div class="stars pull-left">
                    
  <form id = "rating-form" action="msrating.php" method="post">
    <input type="hidden" name="movieId" value="$movieId">
    <input class="star star-5" id="star-5" type="radio" name="star" onclick="submit()" value = "5"/>
    <label class="star star-5" for="star-5"></label>
    <input class="star star-4" id="star-4" type="radio" name="star" onclick="submit()" value = "4"/>
    <label class="star star-4" for="star-4"></label>
    <input class="star star-3" id="star-3" type="radio" name="star" onclick="submit()" value = "3"/>
    <label class="star star-3" for="star-3"></label>
    <input class="star star-2" id="star-2" type="radio" name="star" onclick="submit()" value = "2"/>
    <label class="star star-2" for="star-2"></label>
    <input class="star star-1" id="star-1" type="radio" name="star" onclick="submit()" value = "1"/>
    <label class="star star-1" for="star-1"></label>
  </form>
</div>
<br />
STR;
            }
            if($Rating > 0){
          
                $output .="<br /><br /><br /><h5 class ='pull-left'>Your current rating: "
                        . "<span class='text-success'><em>$Rating</em></span></h5><br />";
            }
            $output .= <<<STR
                 <div class ="row row-content">
                    <div class="panel panel-primary" id ="movie-panel">
                         <div class="panel-heading">
                             <h3 class="panel-title">Movie Details</h3>
                         </div>
                    
                         <div class="panel-body">
                             <dl class = "dl-horizontal" id ="movie-panel-list">
                                 <dt>Movie Title</dt>
                                 <dd>$MovieTitle</dd>
                                 <dt>Summary</dt>
                                 <dd>$Summary</dd>
                                 <dt>Budget</dt>
                                 <dd>$ $AmountBudgeted</dd>
                                 <dt>Genre</dt>
                                 <dd>$GenreType</dd>
                                 <dt>Date In Theaters</dt>
                                 <dd>$DateInTheaters</dd>
                         </div>
                    </div>
                     </div>
                </div>
        </div>
   </div>          
STR;
echo $output;

// call the displayPageFooter method in siteCommon2.php

displayPageFooter();

?>
