<?php
/*
    Date: January 2017
    Uses: siteCommon2.php, d10sql.php
 */

session_start();

require_once ("./mssql.php");
require_once './siteCommon.php';

$homePage = 'msloginform.php';
$userID = $_SESSION['userInfo']['userid'];

$userDetails = getUserDetails($userID);


// assign form values to variables

$userLogin = (isset($_POST['userlogin'])) ? trim($_POST['userlogin']) : '';
$userPassword = (isset($_POST['userpassword'])) ? trim($_POST['userpassword']) : '';
$firstName = (isset($_POST['firstname'])) ? trim($_POST['firstname']) : '';
$lastName = (isset($_POST['lastname'])) ? trim($_POST['lastname']) : '';
$address = (isset($_POST['address'])) ? trim($_POST['address']) : '';
$city = (isset($_POST['city'])) ? trim($_POST['city']) : '';
$state = (isset($_POST['state'])) ? trim($_POST['state']) : '';
$zip = (isset($_POST['zip'])) ? trim($_POST['zip']) : '';
$country = (isset($_POST['country'])) ? trim($_POST['country']) : '';
$eMail = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$phone = (isset($_POST['phone'])) ? trim($_POST['phone']) : '';


// if the form was submitted

if (isset($_POST['register']))
{
    
        // insert new record

        updateUser($userID,$userLogin, $userPassword, $firstName, $lastName, $address, $city, $state, $zip, $country, $eMail, $phone);

        //redirect user to login page

        header('Refresh: 1; URL=mslogin.php');
        echo '<h2>Thank you for Updating.  You will now be redirected to the home page.<h2>';
        die();
}
require_once ("./siteCommon.php");

// call the displayPageHeader method in siteCommon2.php

displayPageHeader();
extract($userDetails[0]);

// if the user chose a duplicate username, display error

if (!empty($error))
{
    echo '<div id="error">' . $error . '</div>';
}
?>
<div class="container center_div center">
    <div class="row row-content">
        <div class="col-xs-12 col-sm-9">
            
        
<form name ="addUserForm" class="form-horizontal" role="form" id="addUserForm" action="msmodify.php" method="post">
    <div class="form-group">
    <label for="userlogin" class="col-sm-5">Username:</label>
    <div class="col-sm-4">
   <input type="text" name="userlogin" id ="userlogin" value="<?php echo $username; ?>" readonly class="form-control" maxlength="10"  required="required" pattern="^[\w@\.-]+$" title="Valid characters are a-z 0-9 _ . @ -" /><br />
   </div>
    </div>
   <div class="form-group">
    <label for="userpassword" class="col-sm-5">Password:</label> 
   <div class="col-sm-4">
       <input type="password" name="userpassword" id="userpassword" value="<?php echo $password; ?>" class="form-control" maxlength="10" required="required" pattern="^[\w@\.-]+$" title="Valid characters are a-z 0-9 _ . @ -" autofocus /><br />
   </div>
        </div>
    <div class="form-group">
   <label for="firstname" class="col-sm-5">First Name:</label>
   <div class="col-sm-4">
       <input type="text" name="firstname" id ="firstname" value="<?php echo $firstname; ?>" maxlength="20" class="form-control" required="required" pattern="^[a-zA-Z-]+$" title="First Name has invalid characters" /><br />
   </div></div>
   <div class="form-group" >
   <label for="lastname" class="col-sm-5">Last Name:</label>
   <div class="col-sm-4">
       <input type="text" name="lastname" id ="lastname" value="<?php echo $lastname; ?>" maxlength="20" class="form-control" required="required" pattern="^[a-zA-Z-]+$" title="Last Name has invalid characters" /><br />
   </div></div>
   <div class="form-group">
   <label for="address" class="col-sm-5">Address:</label>
   <div class="col-sm-4">
       <input type="text" name="address" id ="address" value="<?php echo $address; ?>" maxlength="50" class="form-control" required="required" pattern="^[a-zA-Z0-9][\w\s\,\.]*[a-zA-Z0-9\.]$" title="Address has invalid characters" /><br />      
   </div></div>
   <div class="form-group">
   <label for="city" class="col-sm-5">City:</label>
   <div class="col-sm-4">
       <input type="text" name="city" id ="city" value="<?php echo $city; ?>" maxlength="30" class="form-control" required="required" pattern="^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$" title="City has invalid characters" /><br />
   </div></div>
   <div class="form-group">
   <label for="state" class="col-sm-5">State:</label>
   <div class="col-sm-4">
       <input type="text" name="state" id ="state" value="<?php echo $state; ?>" class="form-control" maxlength="2" required="required" pattern="^[a-zA-Z]{2}$" title="Enter a valid state" /><br />
   </div></div>
   <div class="form-group">
   <label for="zip" class="col-sm-5">Zip:</label>
   <div class="col-sm-4">
       <input type="text" name="zip" id ="zip" value="<?php echo $zip; ?>" maxlength="10" class="form-control" required="required" pattern="^\d{5}(-\d{4})?$" title="Enter a valid 5 or 9 digit zip code" /><br />   
   </div></div>
   <div class="form-group">
   <label for="country" class="col-sm-5">Country:</label>
   <div class="col-sm-4">
       <input type="text" name="country" id ="country" value="<?php echo $country; ?>" maxlength="20" class="form-control" required="required" pattern="^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$" title="Country has invalid characters" /><br />    
   </div></div>
   <div class="form-group">
   <label for="email" class="col-sm-5">Email:</label>
   <div class="col-sm-4">
       <input type="text" name="email" id ="email" value="<?php echo $email; ?>" maxlength="50" class="form-control" required="required" pattern="^([\w-\.]+)@([\w]+)\.([a-zA-Z]{2,4})$" title="Enter a valid email" /> <br />
   </div></div>
   <div class="form-group">
   <label for="phone" class="col-sm-5">Telephone:</label>
   <div class="col-sm-4">
       <input type="text" name="phone" id ="phone" value="<?php echo $phone; ?>" maxlength="12" class="form-control" required="required" pattern="^(\d{3}-)?\d{3}-\d{4}$" title="Enter a valid phone number" /><br />
   </div>
   </div>
    <!--<div class="col-sm-7 col-sm-offset-5">-->
   <div class="form-group">
    <div class="row">
      <input type="submit" class="col-sm-offset-4 col-sm-2 btn btn-primary" value="Update" name="register" /> 
      <a href="mslogin.php"  class="col-sm-offset-1 col-sm-2 btn btn-primary" name="cancel" >Cancel</a>
   </div>
   </div>
       <!--</div>-->
</form>
            </div>
        </div>
</div>

<?php
// call the displayPageFooter method in siteCommon2.php

displayPageFooter();

?>
