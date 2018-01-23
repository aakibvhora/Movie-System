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
}

$output = <<<STR
    <div class="container center_div center">
        <div class="row row-content">
            <div class="col-xs-12 col-sm-9">
            <h2 style="text-align:left">Search Movies by Title and/or Genre</h2><br />
                <form name ="searchMovieForm" class="form-horizontal" role="form" id="searchMovieForm" action="mssearchmovie.php" method="get">
                    <div class="form-group">
                        <label for="movietitle" class="col-sm-5">Movie Title:</label>
                        <div class="col-sm-4">
                            <input type="text" name="movietitle" id ="movietitle" class="form-control"  autofocus="autofocus" /><br />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="genre" class="col-sm-5">Genre:</label> 
                        <div class="col-sm-4">
                           <select name="genreid" id="genreid" class="form-control">
                                <option>
                                    
                                </option>
                                
STR;
                                    $genrelist = getGenres();
                foreach ($genrelist as $genre){
                    
                    extract($genre);
                        $output .= "<tr>";
                    $output .= "<option value=$genreid>$genretype</option>";
                }
$output .= <<<STR
        
                                
                           </select> <br />
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                          <input type="submit" class="col-sm-offset-5 col-sm-2 btn btn-primary" value="Search" name="register" /> 
                       </div>
                    </div>
                </form>
            </div>
        </div>
    <div>        

                        
STR;
                
$output .= <<<STR
                        </table>
                    </div>
                </div>
            
        </div>
    </div>
STR;
echo $output;

displayPageFooter();