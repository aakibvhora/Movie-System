<?php
/*
    Purpose: Movie System
    Date: March 2017
    Uses: dbConnExec.php
 */

require_once './dbConnExec.php';


//Added by Aakib Vhora

// checks whether a user with the provided credentials exists

function getUser($userName, $password)
{
    $query = <<<STR
Select userid, firstname
From users Where username = '$userName'
and password = '$password'
STR;

return executeQuery($query);

}

//get user details

function getUserDetails($userID)
{
    $query = <<<STR
Select username,password,firstname,lastname,address,city,state,zip,country,email,phone
From users Where userid = '$userID'
STR;
return executeQuery($query);

}




// checks whether a username alreadys exists

function findDuplicateUser($userName)
{
    $query = <<<STR
Select username
From users
Where username = '$userName'
STR;

return executeQuery($query);
}

// inserts a new row in the user table

function addUser($userName, $password, $firstName, $lastName, $address, $city, $state, $zip, $country, $eMail, $phone)
{
    $query = <<<STR
Insert Into users(userid,username, password, firstname, lastname, address, city, state, zip, country, email, phone)
Values(NEWID(),'$userName','$password','$firstName','$lastName','$address','$city', '$state','$zip','$country','$eMail','$phone')
STR;

    executeQuery($query);
}


// inserts a new row in the user table

function updateUser($userID,$userName, $password, $firstName, $lastName, $address, $city, $state, $zip, $country, $eMail, $phone)
{
    $query = <<<STR
Update users set username='$userName', password='$password', firstname='$firstName', lastname='$lastName', address='$address', city='$city', state='$state', zip=$zip, country='$country', email='$eMail', phone='$phone'
Where userid='$userID' 
STR;
    executeQuery($query);
}



function getTopMovies()
{
    $query = <<<STR
            Select TOP 10 movieid,movietitle,pitchtext,summary
            From movie order by DateInTheaters desc
STR;
    return executeQuery($query);
}





//Already exist methods

// get movie ratings

function getMovieRatings()
{
    $query = <<<STR
Select ratingpk, rating
From filmrating
Order by ratingpk
STR;

    return executeQuery($query);
}

// get a specific movie rating

function getAMovieRating($ratingPK)
{
    $query = <<<STR
Select ratingpk, rating
From filmrating
where ratingpk = $ratingPK
STR;

    return executeQuery($query);
}

// search film table on multiple criteria

//function getMoviesByMultiCriteria($movieTitle,$pitchText,$ratingPK)
//{
//    $query = <<<STR
//Select filmpk, movietitle, pitchtext, summary, dateintheaters
//From film
//Where 0=0
//STR;
//    if ($movieTitle != '')
//    {
//    $query .= <<<STR
//And movietitle like '%$movieTitle%'
//STR;
//    }
//    if ($pitchText != '')
//    {
//    $query .= <<<STR
//And pitchtext like '%$pitchText%'
//STR;
//    }
//    if ($ratingPK != '')
//    {
//    $query .= <<<STR
//And ratingfk = $ratingPK
//STR;
//    }
//$query .= <<<STR
//Order by movietitle
//STR;
//
//return executeQuery($query);
//
//}

//get title for a specific movie

function getAMovieTitle($filmPK)
{
    $query = <<<STR
Select movietitle
From film
where filmpk = $filmPK
STR;

    return executeQuery($query);
}

function getMoviesByGenre($genreid){
    $query = <<<STR
Select movieid, movietitle, pitchtext,summary
From movie
Where moviegenre = $genreid
STR;
    return executeQuery($query);
}


function getMoviesByMultiCriteria($genreid,$movietitle)
{
    $query = <<<STR
Select movieid, movietitle, pitchtext,summary
From movie
Where 0=0
STR;
    if ($genreid != '')
    {
        $query .= <<<STR
        And moviegenre = $genreid
STR;
    }

    if ($movietitle != '')
    {
        $query .= <<<STR
        And movietitle like '%$movietitle%'
STR;
    }

$query .= <<<STR
Order by movietitle
STR;

return executeQuery($query);

}




////get title for a specific movie
function getGenres(){
    $query = <<<STR
Select genreid, genretype from moviegenre;
STR;

    return executeQuery($query);
}

function getMovieDetails($movieId)
{
    $query = <<<STR
Select movieId, MovieTitle, PitchText, AmountBudgeted, Summary, DateInTheaters, GenreType, MovieGenre
From movie m inner join movieGenre g on m.moviegenre = g.genreid
where m.movieid = $movieId
STR;

    return executeQuery($query);
}
// get reviews for a specific movie


function getMoviesFromWatchList($userId){
    $query = <<<STR
Select movieId, movietitle, pitchtext,summary
From movie 
where movieid in (Select movieid from WatchList where userID = '$userId')
STR;

    return executeQuery($query);
}

function isPresentInWatchList($userId, $movieId)
{
    $query = <<<STR
            Select * 
            From WatchList
            Where UserId= '$userId' and MovieId = '$movieId'
STR;
    return executeQuery($query);
}


function addToWatchList($userId, $movieId){
    $query = <<<STR
            Insert into WatchList (UserId, MovieId)
            Values('$userId', '$movieId')
STR;
    
    return executeQuery($query);
  
}
function getMovieRating($userId, $movieId){
    $query = <<<STR
            Select Rating
            From Rating
            Where UserID = '$userId' and MovieId = '$movieId'
STR;
    
    return executeQuery($query);
}

function insertMovieRating($userId, $movieId, $rating){
    $query = <<<STR
            Insert into Rating(userid, movieid, rating)
            values('$userId', '$movieId', $rating)
STR;
    
    return executeQuery($query);
}

function updateMovieRating($userId, $movieId, $rating){
    $query = <<<STR
            Update Rating
            set Rating = $rating
            Where UserID = '$userId' and MovieId = '$movieId'
STR;
    
    return executeQuery($query);
}
function removeFromWatchList($userId, $movieId){
    $query = <<<STR
            Delete From WatchList 
            Where userId = '$userId' and movieId = '$movieId'
STR;

    return executeQuery($query);
}
function getMovieReviews($filmPK)
{
    $query = <<<STR
Select reviewpk, reviewdate, reviewsummary, reviewrating, contactfk, firstname, lastname
From filmreview inner join contact on contactpk = contactfk
where filmfk = $filmPK
STR;

    return executeQuery($query);
}

// get reviews for a specific movie

function getUserReviews($contactPK)
{
    $query = <<<STR
Select reviewpk, reviewdate, reviewsummary, reviewrating, movietitle
From filmreview inner join film on filmpk = filmfk
where contactfk = $contactPK
Order by reviewdate desc
STR;

    return executeQuery($query);
}

// get details for a secific review

function getReviewDetails($reviewPK, $contactFK)
{
    $query = <<<STR
Select reviewsummary, reviewrating, movietitle
From filmreview inner join film on filmpk = filmfk
where reviewpk = $reviewPK and contactfk = $contactFK
STR;

    return executeQuery($query);
}

// checks whether a user with the provided credentials exists

//function getUser($userLogin, $userPassword)
//{
//    $query = <<<STR
//Select contactpk, firstname, userrolename
//From contact inner join userrole
//on userrolefk = userrolepk
//Where userlogin = '$userLogin'
//and userpassword = '$userPassword'
//STR;
//
//return executeQuery($query);
//
//}
//
//// checks whether a username alreadys exists
//
//function findDuplicateUser($userLogin)
//{
//    $query = <<<STR
//Select userlogin
//From contact
//Where userlogin = '$userLogin'
//STR;
//
//return executeQuery($query);
//}
//
//// inserts a new row in the contacts table
//
//function addCustomer($userLogin, $userPassword, $firstName, $lastName, $address, $city, $state, $zip, $country, $eMail, $phone, $mailingList)
//{
//    $query = <<<STR
//Insert Into contact(userlogin, userpassword, firstname, lastname, address, city, state, zip, country, email, phone, mailinglist)
//Values('$userLogin','$userPassword','$firstName','$lastName','$address','$city', '$state','$zip','$country','$eMail','$phone','$mailingList')
//STR;
//
//    executeQuery($query);
//}



// insert a new review

function addReview($filmFK, $reviewSummary, $reviewRating, $contactFK)
{
    $query = <<<STR
Insert Into filmreview(reviewsummary,reviewrating,filmfk,contactfk)
Values('$reviewSummary',$reviewRating,$filmFK,$contactFK)
STR;

    executeQuery($query);
}

// Update a review

function updateReview($reviewPK, $reviewSummary, $reviewRating)
{
    $query = <<<STR
Update filmreview
Set reviewsummary = '$reviewSummary', reviewrating = $reviewRating
Where reviewpk = $reviewPK
STR;

    executeQuery($query);
}

// delete a secific review

function deleteReview($reviewPK, $contactFK)
{
    $query = <<<STR
delete
from filmreview            
where reviewpk = $reviewPK and contactfk = $contactFK
STR;

    return executeQuery($query);
}


function getGenreType($genreid){
switch ($genreid) {
    case 1:
        $genretype="Action";
        break;
    case 2:
        $genretype="Adventure";
        break;
    case 3:
        $genretype="Animation";
        break;
    case 4:
        $genretype="Biograhy";
        break;
    case 5:
        $genretype="Comedy";
        break;
    case 6:
        $genretype="Crime";
        break;
    case 7:
        $genretype="Documentary";
        break;
    case 8:
        $genretype="Drama";
        break;
    case 9:
        $genretype="Family";
        break;
    case 10:
        $genretype="Fantasy";
        break;
    case 11:
        $genretype="Film-Noir";
        break;
    case 12:
        $genretype="Game-Show";
        break;
    case 13:
        $genretype="History";
        break;
    case 14:
        $genretype="Horror";
        break;
    case 15:
        $genretype="Music";
        break;
    case 16:
        $genretype="Musical";
        break;
    case 17:
        $genretype="Mystery";
        break;
    case 18:
        $genretype="News";
        break;
    case 19:
        $genretype="Reality-TV";
        break;
    case 20:
        $genretype="Romance";
        break;
    case 21:
        $genretype="Sci-Fi";
        break;
    case 22:
        $genretype="Sport";
        break;
    case 23:
        $genretype="Talk-Show";
        break;
    case 24:
        $genretype="Thriller";
        break;
    case 25:
        $genretype="War";
        break;
    case 26:
        $genretype="Western";
        break;
}
return $genretype;
}



