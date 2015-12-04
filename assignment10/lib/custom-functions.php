<?php
//&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&*&
//
// file is for custom functions that you dont know where else to put
// 

// The idea here is to look for sql injection techniques and replace them with
// a character which will cause the sql statement to simply fail
function sanitize($string, $spacesAllowed = true, $semiColonAllowed = true) {
    $replaceValue = "Q";

    if (!$semiColonAllowed) {
        $string = str_replace(';', $replaceValue, $string);
    }
    
    if (!$spacesAllowed) {
        $string = str_replace(' ', $replaceValue, $string);
    }
    $string = htmlentities($string, ENT_QUOTES);

    $string = str_replace('%20', $replaceValue, $string);

    return $string;
}


function checkUser($username)
{
    $columns = 3;
    $query = "SELECT pmkNetID, fldConfirmed, fldAdmin FROM tblUser WHERE pmkNetID = ?";
    //$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    //$entries = $thisDatabaseReader->testquery($query, array($username), 1, 0, 0, 0, false, false);
    $entries = $thisDatabase->select($query, array($username), 1, 0, 0, 0, false, false);
    
    if ($entries = '') 
    {
        print 'did not find the user';
    }
    
    else  
    {
        print 'found the user';
    }
    
}