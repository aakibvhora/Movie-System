<?php
   /* 
    Purpose: Methods to render Common Site Header and Footer
    Date: January 2017
     */
        
function displayPageHeader()
{
   $output = <<<ABC
<!DOCTYPE html>
<html>
    <head>
       <title>Movie System</title>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       
       <link href="css/myStyles.css" rel="stylesheet" type="text/css"/>
       <link href="css/font-awesome.css" rel="stylesheet" type="text/css"/>
       <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
       <link href="css/footerStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

<header>
<nav class="navbar navbar-nav navbar-fixed-top" role="navigation">
                <div >
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        
                    </button>
                        <a class="navbar-brand" href="home.php"><i class="fa fa-film"> </i></a>
                    </div>
                    
                    <div id="navbar navbar-left" class="navbar-collapse collapse row">
                        <div class="col-xs-12 col-sm-5 col-lg-5">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#home.php"><span class="fa fa-home"
                                 aria-hidden="true"></span> Home</a></li>
                            <li><a href="#browse.php"><span class="fa fa-folder-o"
                                 aria-hidden="true"></span> Browse Movies</a></li>
                             <li><a href="#search.php"><i class="fa fa-search"></i> Search Movies</a></li>
                        </ul>
                        </div>
ABC;

// the session array element "userInfo" will be set (see d8loginform.php) if the user has been authenticated

$logStatus = (!isset($_SESSION['userInfo']));   

// if the user is authenticated, display "Log Out", else Log In"

    if ($logStatus)
    {
        
        $str= <<<STR
                            <div class="navbar-right col-xs-12 col-sm-7 col-lg-6">
                            <form class="navbar-form navbar-right" role="form" method="post" action="mslogin.php">
                                    <div class="form-group row">
                                        <!--<label class="sr-only" for="email">Email</label>-->
                                        <input type="hidden" name ="redirect" value ="<?php echo $redirect ?>" />
                                        <div class="input-group col-xs-12 col-sm-3">
                                            <input type="text" name="username" class="form-control" id="username" placeholder="User Name">
                                        </div>

                                        <!--<label class="sr-only" for="password">Password</label>-->
                                        <div class="input-group col-xs-12 col-sm-3">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                        </div>
                                        <div class="input-group button col-xs-12 col-sm-2">
                                            <button type="submit" name="login" class="btn btn-primary btnSub">Submit</button>
                                        </div>
                                        <div class="input-group form-check col-xs-12 col-sm-3">
                                            <a href="mscreate.php" style="text-decoration: underline" > Create Account</a>
                                        </div>

                                        
                                    </div>

                                </form>
                        </div>
STR;
                

    }
    else
    {
        $str = <<<STR
                <div class="navbar-right col-xs-12 col-sm-7 col-lg-6">
                        <div class="navbar-form navbar-right">
                                    <div class="form-group row">
                                        <div class="input-group col-xs-9">
                                            <a name="lnkUser" class="" style="" href="mscreate.php"> My Account</a>
                                        </div>
                                        <div class="input-group button col-xs-3">
                                            <a name="logout" class="btn btn-primary btnSub" style="margin-right:50px;" href="mslogout.php">Logout</a>
                                        </div>
                
                                    </div>
                                     </div>
                        </div>
                
STR;
        
    }
  $output .= $str;
  
    $output .= "</div></div></nav></header>";

   echo $output;
}
   
function displayPageFooter()
{
   $output = <<<ABC
   <div class="footer footer-bottom navbar-fixed-bottom">

	<div class="container">

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<div class="copyright">

					© 2017, Team121, All rights reserved

				</div>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<div class="design">

					 Developed By:- <a href="#">Aakib Vhora</a> |  <a target="_blank" href="#">Sreenivas Potukuchi</a> |  <a target="_blank" href="#">Sanjay Taneeru</a>

				</div>

			</div>

		</div>

	</div>

</div>

    </body>
</html>
ABC;
   echo $output;
}
?>
