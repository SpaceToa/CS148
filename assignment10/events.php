<?php
include "top.php";

if (isset($_POST["btnSubmit"]))
{
    print 'registered';
    
    $username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");

    $columns = 3;
    $queryTest = "SELECT pmkNetID, fldConfirmed, fldAdmin FROM tblUser WHERE pmkNetID = ?";
    //$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    //$entries = $thisDatabaseReader->testquery($query, array($username), 1, 0, 0, 0, false, false);
    $entriesTest = $thisDatabaseReader->select($queryTest, array($username), 1, 0, 0, 0, false, false);
    
  
        try 
        {   
            $thisDatabaseWriter->db->beginTransaction();
        
            $data[] = $username;
            $data[] = $eventName;

            $query = 'INSERT INTO fldAttendance SET ';
            $query .= 'fnkUser = ?, ';
            $query .= 'fnkName = ?, ';
            $query .= 'fldConfirmed = 0 ';

            $results = $thisDatabaseWriter->insert($query, $data);
            $primaryKey = $thisDatabaseWriter->lastInsert();
            $dataEntered = $thisDatabaseWriter->db->commit();

            print 'registered';
        
        }
        catch (PDOExecption $e) 
        {
            $thisDatabase->db->rollback();
        }
    }
    
    else  
    {
        //print'Welcom Back';
    }

?>



<?php

print'<aside>';
    
    $columns = 5;
    $query = "SELECT `pmkName`, `fldLocation`, `fldDate`, `fldTime`, `fldInfo` FROM `tblEvent` ";
    
    //$events = $thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
    $events = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);

//    print '<p>';
//    print 'SQL:';
//    print  $query;
//    print '<br>';
//    print 'TotalRecords=';
//    print count($entries);
//    print '</p>';
//    print'<table>';

    
    foreach ($events as $event) {
        print"<aside>"
        . "<h2 class = 'eventName'>$event[pmkName]</h2>"
        . "<p class='eventLocation'>$event[fldLocation]</p>"
        . "<p class='eventDate'>$event[fldDate]</p>"
        . "<p class='eventTime'>$event[fldTime]</p>"
        . "<p class='eventInfo'>$event[fldInfo]</p>"
        . "<form method='post'>"
        . "<button id='btnSubmit' name='btnSubmit' tabindex='900' value = '" . $event[pmkName] . "' >Attend event</button>"
        . "</form>"
        . "</aside>";
        
    }
    // all done
    print '</table>';
    print '</aside>';

include "footer.php";
?>