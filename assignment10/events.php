<?php
include "top.php";
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
        . "</aside>";
        
    }
    // all done
    print '</table>';
    print '</aside>';

include "footer.php";
?>