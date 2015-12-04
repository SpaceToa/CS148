<?php

$update = 0;

$name="";
$account="";
$system="";
$game="";
$description="";

$nameERROR="";
$accountERROR="";
$systemERROR="";
$gameERROR="";
$descriptionERROR="";

$errorMsg = array();
$data = array();
$dataEntered = false; 
if (isset($_POST["btnSubmit"])) 
{
    
    $name = htmlentities($_GET["txtName"],ENT_QUOTES,"UTF-8");
    $account=htmlentities($_GET["txtAccount"],ENT_QUOTES,"UTF-8");
    $system=htmlentities($_GET["system"],ENT_QUOTES,"UTF-8");
    $game=htmlentities($_GET["txtGame"],ENT_QUOTES,"UTF-8");
    $description=htmlentities($_GET["txtDescription"],ENT_QUOTES,"UTF-8");
    
    if ($name == "") {
        $errorMsg[] = "Please enter your first name";
        $nameERROR = true;
    } elseif (!verifyAlphaNum($name)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $nameERROR = true;
    }
    
    if ($account == "") {
        $errorMsg[] = "Please enter your name";
        $accountERROR = true;
    } elseif (!verifyAlphaNum($account)) {
        $errorMsg[] = "Your account appears to have extra character.";
        $accountERROR = true;
    }

    if ($game == "") {
        $errorMsg[] = "Please enter your game name";
        $gameERROR = true;
    } elseif (!verifyAlphaNum($game)) {
        $errorMsg[] = "Your game name appears to have extra character.";
        $gameERROR = true;
    }
    
        if ($description == "") {
        $errorMsg[] = "Please enter a description";
        $descriptionERROR = true;
    } elseif (!verifyAlphaNum($descriptionERROR)) {
        $errorMsg[] = "Your description appears to have extra character.";
        $descriptionERROR = true;
    }
    
//get date and current time
    date_default_timezone_set(America/New_York);
    $date = date('m/d/Y', time());
    $timeSubmit = date('H:i:s', time()); 

//getNetID
    $netID = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    
     $dataEntered = false;
        try {
            $thisDatabase->db->beginTransaction();

            if ($update) {
                $query = 'UPDATE tblEntries SET ';
            } else {
                $query = 'INSERT INTO tblEntries SET ';
            }

            $query .= 'fldGameName = ?, ';
            $query .= 'fldSystem = ?, ';
            $query .= 'fkdAccount = ?, ';
            $query .= 'fldName = ?, ';
            $query .= 'fldDescription = ?, ';
            $query .= 'fldDate = ?, ';
            $query .= 'fldTime = ?, ';
            $query .= 'fnkNetID = ?, ';
            $query .= 'pmkDisplayOrder = ?, ';
            

            if ($update) {
                $query .= 'WHERE pmkDisplayOrder = ?';
                $data[] = $pmkPoetId;

                if ($_SERVER["REMOTE_USER"] == 'aegreen') {
                    $results = $thisDatabase->update($query, $data, 1, 0, 0, 0, false, false);
                }
            } else {
                if ($_SERVER["REMOTE_USER"] == 'aegreen'){
                    $results = $thisDatabase->insert($query, $data);
                    $primaryKey = $thisDatabase->lastInsert();
                    if ($debug) {
                        print "<p>pmk= " . $primaryKey;
                    }
                }
            }

            // all sql statements are done so lets commit to our changes
            //if($_SERVER["REMOTE_USER"]=='rerickso'){
            $dataEntered = $thisDatabase->db->commit();
            // }else{
            //     $thisDatabase->db->rollback();
            // }
            if ($debug)
                print "<p>transaction complete ";
        } catch (PDOExecption $e) {
            $thisDatabase->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
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
        
}

?>

<html>
   <?php
    include('header.php');
    include('nav.php');
    ?>

        <form>
            <fieldset>
                <label for="txtName">Name</label>
                <input type="text" id="txtName" name="txtName" size="35"
                       <?php if($nameERROR) echo 'class="mistake"'; ?>
                       value="<?php echo $name; ?>" 
                       tabindex="105" maxlength="30" placeholder="enter your name" autofocus onfocus="this.select()" >


                <label>System</label>
                <select id="system" name="system" tabindex="110" size="1">
                    <option value="PC" <?php if($align =="PC") echo ' selected="selected" ';?>>PC</option>
                    <option value="PS3" <?php if($align =="PS3") echo ' selected="selected" ';?>>PS3</option>
                    <option value="Xbox-360" <?php if($align =="Xbox-360") echo ' selected="selected" ';?>>Xbox 360</option>
                    <option value="PS4" <?php if($align =="PS4") echo ' selected="selected" ';?>>PS4</option>
                    <option value="Xbox-One" <?php if($align =="Xbox-One") echo ' selected="selected" ';?>>Xbox One</option>
                    <option value="Nintendo-3DS" <?php if($align =="Nintendo-3DS") echo ' selected="selected" ';?>>Nintendo 3DS</option>
                    <option value="WiiU" <?php if($align =="WiiU") echo ' selected="selected" ';?>>WiiU</option>
                </select>

                <label for="txtAccount">Account Name</label>
                <input type="text" id="txtAccount" name="txtAccount" size="35" 
                       <?php if($accountERROR) echo 'class="mistake"'; ?>
                       value="<?php echo $account; ?>" 
                       tabindex="115" maxlength="30" placeholder="enter account name/ID"  onfocus="this.select()" >

                <label for="txtGame">Game</label>
                <input type="text" id="txtGame" name="txtGame" size="35" 
                       value="<?php echo $game; ?>" 
                       tabindex="120" maxlength="30" placeholder="enter title of game"  onfocus="this.select()" >
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
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="991" class="button">

                <input type="reset" id="butReset" name="butReset" value="Reset Form" tabindex="993" class="button" onclick="reSetForm()">
            </fieldset>
         
        </form>

       <?php
    include('footer.php');
    ?>
</body>
</html>