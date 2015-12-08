<?php
include "top.php";

$debug =true;

$netID = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");



$update = 0;

$name="";
$account="";
$system="";
$game="";
$description="";
$email = $netID . "@uvm.edu";
$meet = 0;
$mic = 0;
$comp = 0;
$cas = 1;
$trol = 0;

$nameERROR="";
$accountERROR="";
$systemERROR="";
$gameERROR="";
$descriptionERROR="";

$errorMsg = array();
$data = array();
$dataEntered = false; 

if($debug)
{
    print'debug is on' . '</br>';
    
    print $netID . '<br>';
    print $email . '<br>';
    
   
}

if (isset($_POST["btnSubmit"])) {
    
    if($debug)
{
    print'submit button pressed' . '</br>';
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    /*    if (!securityCheck(true)) {
      $msg = "<p>Sorry you cannot access this page. ";
      $msg.= "Security breach detected and reported</p>";
      die($msg);
      }
     */


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.
//    $pmkPoetId = (int) htmlentities($_POST["hidPoetId"], ENT_QUOTES, "UTF-8");
//    if ($pmkPoetId > 0) {
//        $update = true;
//    }
    // I am not putting the ID in the $data array at this time

    $game = htmlentities($_POST["txtGame"], ENT_QUOTES, "UTF-8");
    $data[] = $game;

    $system = htmlentities($_POST["system"], ENT_QUOTES, "UTF-8");
    $data[] = $system;
    
    $account = htmlentities($_POST["txtAccount"], ENT_QUOTES, "UTF-8");
    $data[] = $account;
    
    $name = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
    $data[] = $name;
    
    $description = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");
    $data[] = $description;
    
    $date = date('Y-m-d', time());
    $data[] = $date;
    
    $timeSubmit = date('H:i:s', time()); 
    $data[] = $timeSubmit;
    
    $data[] = $netID;
    
    //Add $meet to $data
    
    if ($_POST['radMeetup']== 0) 
    {
        $meet = 0;
    }
    else
    {
        $meet = 1;
    }
    $data[] = $meet ;
    
    //Add $mic to $data
    if ($_POST['radMic']== 0) 
    {
        $mic = 0;
    }
    else
    {
        $mic = 1;
    }
    $data[] = $mic ;
    
    //Add check box values to $data
    if(isset($_POST["chkComp"])) {
        $comp = 1;        
    }else{
        $comp  = 0;
    }
    $data[] = $comp;
    
    if(isset($_POST["chkCas"])) {
        $cas = 1;
    }else{
        $cas  = 0;
    }
    $data[] = $cas;
    
    if(isset($_POST["chkTrol"])) {
        $trol = 1;        
    }else{
        $trol  = 0;
    }
    $data []= $trol;
    
    
    
    
    
    
    if($debug)
{
    print "has NOT been sanitized". '</br>';
//    print $name;
//    print $account;
//    print $system;
//    print $game;
//    print $description;
//    print $date;
//    print $timeSubmit;
//    print $netID . '</br>';
       
    print '<section>';
    print_r($data);
   print '</section>';
}
    
   
    
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//

    if ($name == "") {
        $errorMsg[] = "Please enter your first name";
        $nameERROR = true;
    } elseif (!verifyAlphaNum($name)) {
        $errorMsg[] = "Your name appears to have extra character.";
        $nameERROR = true;
    }
    
    if ($game == "") {
        $errorMsg[] = "Please enter your games name";
        $gameERROR = true;
    } elseif (!verifyAlphaNum($game)) {
        $errorMsg[] = "Your games name appears to have extra character.";
        $gameERROR = true;
    }

    if ($account == "") {
        $errorMsg[] = "Please enter your account name";
        $accountERROR = true;
    } elseif (!verifyAlphaNum($account)) {
        $errorMsg[] = "Your account name appears to have extra character.";
        $accountERROR = true;
    }
    
    if ($description == "") {
        $errorMsg[] = "Please enter a description";
        $descriptionERROR = true;
    } elseif (!verifyAlphaNum($description)) {
        $errorMsg[] = "Your description appears to have extra character.";
        $description = true;
    }
    
    if ($comp == 0 AND $cas == 0 AND $trol == 0 ){
        $errorMsg[] = "Please pick a play style";       
    }

    if($debug)
{
    print "HAS been sanitized" . '</br>';
    print $name;
    print $account;
    print $system;
    print $game;
    print $description;
    print $date;
    print $timeSubmit;
    print $netID . '</br>';
}
    
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug) {
            print "<p>Form is valid</p>";
        }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2e Save Data
//

        $dataEntered = false;
        try {
            $thisDatabaseWriter->db->beginTransaction();

            if ($update) {
                $query = 'UPDATE tblEntries SET ';
            } else {
                $query = 'INSERT INTO tblEntries SET ';
            }

            //$query .= 'pmkID = ?, ';
            $query .= 'fldGameName = ?, ';
            $query .= 'fldSystem = ?, ';
            $query .= 'fldAccount = ?, ';
            $query .= 'fldName = ?, ';
            $query .= 'fldDescription = ?, ';
            $query .= 'fldDate = ?, ';
            $query .= 'fldTime = ?, ';
            $query .= 'fnkNetID = ?, ';
            $query .= 'fldMeetUp = ?, ';
            $query .= 'fldMic= ?, ';
            $query .= 'fldComp = ?, ';
            $query .= 'fldCas = ?, ';
            $query .= 'fldTrol = ? ';
            

            if ($update) {
                $query .= 'WHERE pmkID = ?';
                $data[] = $pmkID;
         
                    $results = $thisDatabase->update($query, $data, 1, 0, 0, 0, false, false);
                
            } else {
                
                    $results = $thisDatabaseWriter->insert($query, $data);
                    $primaryKey = $thisDatabaseWriter->lastInsert();
                    if ($debug) {
                        print "<p>pmk= " . $primaryKey;
                    }
               
            }

            // all sql statements are done so lets commit to our changes
            //if($_SERVER["REMOTE_USER"]=='rerickso'){
            $dataEntered = $thisDatabaseWriter->db->commit();
            // }else{
            //     $thisDatabase->db->rollback();
            // }
            if ($debug)
            {
                print "<p>transaction complete ";
                print $query;
            }
        } catch (PDOExecption $e) {
            $thisDatabaseWriter->db->rollback();
            if ($debug)
            {    
                print "Error!: " . $e->getMessage() . "</br>";
            }
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }
    } // end form is valid
}
        if ($errorMsg) {
            print '<div id="errors">';
            print '<h1>Your form has the following mistakes</h1>';

            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
        


?>

<html>
    
    <form method="post">
            <fieldset>
                <label for="txtName">Name</label>
                <input type="text" id="txtName" name="txtName" size="35"
                       <?php if($nameERROR) echo 'class="mistake"'; ?>
                       value="<?php echo $name; ?>" 
                       tabindex="105" maxlength="30" placeholder="enter your name" autofocus onfocus="this.select()" >
                
                <label for="txtEmail">Email</label>
                <input type="text" id="txtEmail" name="txtEmail" size="30"
                       value="<?php echo $email; ?>" 
                       tabindex="105" maxlength="30" readonly autofocus onfocus="this.select()" >


                <label>System</label>
                <select id="system" name="system" tabindex="110" size="1">
                    <option value="PC" <?php if($system =="PC") echo ' selected="selected" ';?>>PC</option>
                    <option value="PS3" <?php if($system =="PS3") echo ' selected="selected" ';?>>PS3</option>
                    <option value="Xbox-360" <?php if($system =="Xbox-360") echo ' selected="selected" ';?>>Xbox 360</option>
                    <option value="PS4" <?php if($system =="PS4") echo ' selected="selected" ';?>>PS4</option>
                    <option value="Xbox-One" <?php if($system =="Xbox-One") echo ' selected="selected" ';?>>Xbox One</option>
                    <option value="Nintendo-3DS" <?php if($system =="Nintendo-3DS") echo ' selected="selected" ';?>>Nintendo 3DS</option>
                    <option value="WiiU" <?php if($system =="WiiU") echo ' selected="selected" ';?>>WiiU</option>
                </select>
                <br>

                <label for="txtAccount">Account Name</label>
                <input type="text" id="txtAccount" name="txtAccount" size="35" 
                       <?php if($accountERROR) echo 'class="mistake"'; ?>
                       value="<?php echo $account; ?>" 
                       tabindex="115" maxlength="30" placeholder="enter account name/ID"  onfocus="this.select()" >

                <label for="txtGame">Game</label>
                <input type="text" id="txtGame" name="txtGame" size="35" 
                       <?php if($gameERROR) echo 'class="mistake"'; ?>
                       value="<?php echo $game; ?>" 
                       tabindex="120" maxlength="30" placeholder="enter title of game"  onfocus="this.select()" >
                <br>
                
                <label for="radMeetup">Where do you want to meet up:</label>
                    <input type="radio" name="radMeetup" value="0" <?php if($meet == 1){} else{print 'checked';} ?> >Online
                    <input type="radio" name="radMeetup" value="1" <?php if($meet == 1){print 'checked';}?> >In person<br>

                <label for="radMic">Can/Would you like to voice chat:</label>
                    <input type="radio" name="radMic" value="0" <?php if($meet == 1){} else{print 'checked';} ?> >Yes
                    <input type="radio" name="radMic" value="1" <?php if($meet == 1){print 'checked';}?> >No<br>
                    
                <label for="chkType">Style of play:</label><br>
                    <input type="checkbox" name="chkComp"  id="chkComp" value="Competitive" <?php if($comp == 1){print 'checked';}?> >Competitive<br>
                    <input type="checkbox" name="chkCas" id="chkCas" value="Casual" <?php if($cas == 0){} else{print 'checked';}?> >Casual<br>     
                    <input type="checkbox" name="chkTrol" id="chkTrol" value="Trolling" <?php if($trol == 1){print 'checked';}?> >Trolling<br>   
                
                </fieldset>
            
                <fieldset>
                <label for="txtDescription">Description</label>
                <input type="text" id="txtDescription" name="txtDescription" size="200"
                       <?php if($descriptionERROR) echo 'class="mistake"'; ?>
                       value="<?php echo $description; ?>" 
                       tabindex="125" maxlength="200" placeholder="What do you want to do? (max 200 char.)"  onfocus="this.select()" >
               </fieldset>
        
            
            <fieldset class="buttons">
                <legend>Submit or Reset the form</legend>				
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">

                <input type="reset" id="butReset" name="butReset" value="Reset Form" tabindex="993" class="button" onclick="reSetForm()">
            </fieldset>
         
        </form>

       <?php
    include('footer.php');
    ?>
</body>
</html>

<?php
/*   $query = 'INSERT INTO tblEntries SET ';
            }

            $query .= 'fldGameName = ?, ';
            $query .= 'fldSystem = ?, ';
            $query .= 'fkdAccount = ?, ';
            $query .= 'fldName = ?, ';
            $query .= 'fldDescription = ?, ';
            $query .= 'fldDate = ?, ';
            $query .= 'fldTime = ?, ';
            $query .= 'fnkNetID = ?, ';
            $query .= 'pmkID = ?, ';
 * 
 *  $data[] = $game;
    $data[] = $system;
    $data[] = $account;
    $data[] = $name;
    $data[] = $description;
    $data[] = $date;
    $data[] = $timeSubmit;
    $data[] = $netID;
 
            
*/
?>