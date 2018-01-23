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
    <div class ="container">
        <div class="row row-content"><!-- row -->
            
        
                <div class="col-xs-12 col-sm-9"><!-- widgets column left -->
                    <h2>Browse Movies by Genre</h2><br />
                    <div class="table-responsive">
                        <table class="table table-striped genrelist">
                            <colgroup>
                                <col />
                                <col />
                                <col />
                                <col />
                            </colgroup>
                                
                        
STR;
                $genrelist = getGenres();
                $count = 0;
                foreach ($genrelist as $genre){
                    
                    extract($genre);
                    if($count % 4 == 0){
                        $output .= "<tr>";
                    }
                    $output .= "<td><a href = 'msbrowsegenre.php?genreid=$genreid&genretype=$genretype'>$genretype</a></td>";
                    $count++;
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