<?php
include "top.php";

$debug = true;

$dataEntered = false;

if ($debug)
{print 'Debug is ON <br>';}

$admin = 0;

$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");

    $columns = 3;
    $queryUser = "SELECT `pmkNetID`, `fldConfirmed`, `fldAdmin` FROM `tblUser` WHERE pmkNetID = ?";
    //$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    //$entries = $thisDatabaseReader->testquery($query, array($username), 0, 0, 0, 0, false, false);
    $entriesUser = $thisDatabaseReader->select($queryUser, array($username), 1, 0, 0, 0, false, false);
    
    // Adding a first time visitor to tblEntries
    if ( empty($entriesUser) == TRUE) 
    {
        //print 'did not find the user';
        try 
        {   
            $thisDatabaseWriter->db->beginTransaction();
        
            $data[] = $username;

            $query = 'INSERT INTO tblUser SET ';
            $query .= 'pmkNetID = ?, ';
            $query .= 'fldConfirmed = 1, ';
            $query .= 'fldAdmin = 0 ';

            $results = $thisDatabaseWriter->insert($query, $data);
            $primaryKey = $thisDatabaseWriter->lastInsert();
            //
            //
            print "<p>pmk= " . $primaryKey;
            //
            //
            $dataEntered = $thisDatabaseWriter->db->commit();

            print 'registered';
        
        }
        catch (PDOExecption $e) 
        {
            $thisDatabaseWriter->db->rollback();
        }
    }
    
    else if($entriesUser[0]['fldAdmin'] == 1)  
    {
        $admin= 1;
        print "<section class='logBox'>";
        print "<h4>Welcome Back</h4>";
        print "<h5>" .$username . " </h5>";
        print "<h5>Standing: Admin </h5>";
        print "</section>";
    }
    
    else   
    {
        $admin= 0;
        print "<section class='logBox'>";
        print "<h4>welcome back</h4>";
        print "<h5>" .$username . " </h5>";
        print "</section>";
    }

if (isset($_POST["btnAttend"]))
{
    //print 'registered';
       
    $username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    $eventName = $_POST['btnAttend'];
    
    $columns = 3;
    $queryUser = "SELECT `pmkNetID`, `fldConfirmed`, `fldAdmin` FROM `tblUser` WHERE pmkNetID = ?";
    //$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    //$entries = $thisDatabaseReader->testquery($query, array($username), 0, 0, 0, 0, false, false);
    $entriesUser = $thisDatabaseReader->select($queryUser, array($username), 1, 0, 0, 0, false, false);
    
    //--------------------------------------------------------------------------------------
    // Adding a first time visitor to tblEntries
   

    if($debug)
    {
        print $username;
        print $eventName;
    }
    

    
    //-------------------------------------------------------------------------------------------------
    //Set attending
        try 
        {   
            $thisDatabaseWriter->db->beginTransaction();
        
            $dataAtd[] = $username;
            $dataAtd[] = $eventName;

            $queryAtd = 'INSERT INTO tblAttendance SET ';
            $queryAtd .= 'fnkNetID = ?, ';
            $queryAtd .= 'fnkName = ?, ';
            $queryAtd .= 'fldConfirmed = 1 ';

            $resultsAtd = $thisDatabaseWriter->insert($queryAtd, $dataAtd);
            $primaryKey = $thisDatabaseWriter->lastInsert();
            $dataEntered = $thisDatabaseWriter->db->commit();

            if($debug)
            {
                print '<br>' . $queryAtd . '<br>';
                print $primaryKey . '<br>';
            }
            
            print 'registered';
        
        }
        catch (PDOExecption $e) 
        {
            $thisDatabaseWriter->db->rollback();
            if ($debug)
            {
                print 'ERROR neede to rollback';
            }
        }
    $email = $username . "@uvm.edu";
        $message = 'You have signed up for this event: <br>';
        $message .= $eventName;
        $message .= '<br>We look forward to seeing you there';
        
        
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Bored Gamers Board <noreply@boredgamersboard.com>";
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "BGB Event Un " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
        if($debug)
        {
            print'<br>' . $email;
            print'<br>' . $message;
            print'<br>' . $mailed;
        }    
}

if (isset($_POST["btnUnReg"]))
{
    try 
    {   
        $thisDatabaseWriter->db->beginTransaction();

        $username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
        $eventName = $_POST['btnUnReg'];

        $data[] = $username;
        $data[] = $eventName;

        $query = "DELETE FROM `tblAttendance` WHERE `fnkNetID` = ? AND `fnkName` = ?";

        //$entrieDeleted = $thisDatabaseWriter->testquery($query, $data, 1, 1, 0, 0, false, false);
        $entrieDeleted = $thisDatabaseWriter->delete($query, $data, 1, 1, 0, 0, false, false);

        $dataEntered = $thisDatabaseWriter->db->commit();
        
        print 'Unregistered'; 
    }
    catch (PDOExecption $e) 
        {
            $thisDatabaseWriter->db->rollback();
            if ($debug)
            {
                print 'ERROR neede to rollback';
            }
        }
    //--------------------------------------------------------------------------
    //Email the client that they unregistered from an event
        
        $email = $username . "@uvm.edu";
        $message = 'You have decided not to attend the event: <br>';
        $message .= $eventName;
        $message .= '<br><br>Thats fine.<br> Hopefully you will join us for one of them';
        
        
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Bored Gamers Board <noreply@boredgamersboard.com>";
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "BGB Event Un " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
        if($debug)
        {
            print'<br>' . $email;
            print'<br>' . $message;
            print'<br>' . $mailed;
        }    
        
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
        unset($dataAtnd);
        print"<aside>"
        . "<h2 class = 'eventName'>$event[pmkName]</h2>"
        . "<p class='eventLocation'>$event[fldLocation]</p>"
        . "<p class='eventDate'>$event[fldDate]</p>"
        . "<p class='eventTime'>$event[fldTime]</p>"
        . "<p class='eventInfo'>$event[fldInfo]</p>"
        . "<form method='post'>";
        
        $username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");    
        $dataAtnd[] = $username;
        $dataAtnd[] = $event['pmkName'];

        $columns = 4;
        $queryAtnd = "SELECT `fnkNetID`, `fnkName`, `fldConfirmed`, `pmkID` FROM `tblAttendance` WHERE `fnkNetID` = ? AND `fnkName` = ? ";

        //$entriesAtnd = $thisDatabaseReader->testquery($queryAtnd, $dataAtnd, 1, 1, 0, 0, false, false);
        $entriesAtnd = $thisDatabaseReader->select($queryAtnd, $dataAtnd, 1, 1, 0, 0, false, false);
        if(empty($entriesAtnd))
        {
            $attending = FALSE;
        }
        else
        {
            $attending = TRUE;
        }
        
        if ($attending)
        {
        print"<button id='btnUnReg' name='btnUnReg' tabindex='900' value = '" . $event['pmkName'] . "' >UnRegisiter</button>";
        } else {
        print"<button id='btnAttend' name='btnAttend' tabindex='900' value = '" . $event['pmkName'] . "' >Attend Event</button>";
        }
        print "</form>"
        . "</aside>";
        
    }
    // all done
    print '</table>';
    print '</aside>';

include "footer.php";
?>