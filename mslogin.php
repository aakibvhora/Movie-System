<?php
/* 
    Purpose: Login Form
    Date: January 2017
    Uses: siteCommon2.php, d10sql.php
 */


session_start();

require_once ("mssql.php");
require_once("./siteCommon.php");
// Set local variables to $_POST array elements (userlogin and userpassword) or empty strings


$userName = (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password = (isset($_POST['password'])) ? trim($_POST['password']) : '';
 


/*  $_REQUEST is an associative array that contains the contents of $_GET, $_POST, and $COOKIE
    $_REQUEST is used because the redirect file name could be received by this script
    either through the URL ($_GET) or as a form varaiable ($_POST).
    The first time this script is accessed the redirect file name
    will be in the URL (see d8logincheck.php).  On subsequent accesses, the redirect file name
    will be passed as a form variable (see below, where $redirect is used to set a hidden field)
 */

$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'mslogin.php';

// if the form was submitted

if (isset($_POST['login']))
{
    //Call getUser method to check credentials

    
    $userList = getUser($userName, $password);
    
    if (count($userList)===1) //If credentials check out
    {
        
        extract($userList[0]);

        // assign user info to an array

        $userInfo = array('userid'=>$userid, 'firstname'=>$firstname);

        // assign the array to a session array element

        $_SESSION['userInfo'] = $userInfo;
        session_write_close(); //typically not required; ensures that the session data is stored

        // redirect the user

    }

    else // Otherwise, assign error message to $error
    {
        $error = 'Invalid login credentials<br />Please try again';
        
    }
}


if (isset($error))
{
    echo '<div id="error" class ="row row-header"><div class="col-xs-9"><br /><p class = "text-danger pull-right">' . $error . '</p></div></div>';
    echo "<script language='javascript'>$('#username').focus();</script>";
}
?>





<?php 
displayPageHeader();
?> 

<!--Main body-->

    
    
    <div class="bs-docs-masthead jumbotron" id="content" tabindex="-1"> 
        <div class="jumbotext container"> 
            <span class="bs-docs-booticon bs-docs-booticon-lg bs-docs-booticon-outline"><i class="fa fa-film"> </i></span> 
            <center>
            <p class="lead">Movie system is the most popular website for information about movies.</p> 
            
            
            </center>
        </div> 
    </div>
    <div class="container">
    
    <div class="row row-content"><!-- row -->
            
        
                <div class="col-xs-12 col-sm-12"><!-- widgets column left -->
                    <h2>Latest Movies</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th>Summary</th>
                            </tr>
                            <?php 
                                $movieList = getTopMovies();
                                
                                foreach ($movieList as $movie) {
                                    extract($movie);
                                    
                                    $output = <<<STR
                                    <tr>
                                            <td><a href ="msmoviedetail.php?movieId='$movieid'" >$movietitle</a></td>
                                            <td>$summary</td>
                                    </tr>
STR;
                                    echo $output;
                                }
                            ?>

                        </table>
                        
                    </div>
                </div><!-- widgets column left end -->
                
    </div>
    <br>
</div>


<!--footer-->
<?php 
displayPageFooter();
?>


<!--<form action="d10loginform.php" name="loginForm" id="loginForm" method="post">

     Store the redirect file name in a hidden field  

   <input type="hidden" name ="redirect" value ="<?php echo $redirect ?>" />
   <label for="userlogin">Username:</label>
   <input type="text" name="userlogin" id ="userlogin" value="<?php echo $userLogin; ?>" maxlength="10" autofocus="autofocus" required="required" pattern="^[\w@\.-]+$" title="User Name has invalid characters" /> <br /> <br />
   <label for="userpassword">Password:</label> 
   <input type="password" name="userpassword" id="userpassword" value="<?php echo $userPassword; ?>" maxlength="10" required="required" pattern="^[\w@\.-]+$" title="Password has invalid characters" />
      <p>
         <input type="submit" value="Login" name="login" /> <br /> <br />
         New customer?  <a href="d10register.php">Register Here</a>
      </p>
</form>-->
