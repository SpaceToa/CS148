<?php
include "top.php";
$tableName = "";
?>

        <p> Welcome to the Burlington Bored Gamers Board! Ever wanted to play some multi-player video games, but you have no one to play with? Now you can post a listing looking for a playgroup, guild, or just a co-op buddy! Browse the latest postings below, filter by your console of choice, or make your own posting!</p>
        <h2> Current Postings </h2> 


        <!--   Console Filter buttons -->
        <aside>
            <ul>
                <a href="home.php"><li class="filter" id="all">All</li></a>
                <a href="pc.php"><li class="filter" id="pc">PC</li></a>
                <a href="xbox360.php"><li class="filter" id="x360">Xbox 360</li></a>
                <a href="xboxone.php"><li class="filter" id="xbone">Xbox One</li></a>
                <a href="ps3.php"><li class="filter" id="ps3">PS3</li></a>
                <a href="ps4.php"><li class="filter" id="ps4">PS4</li></a>
                <a href="n3ds.php"><li class="filter" id="n3ds">Nintendo 3DS</li></a>
                <a href="wiiu.php"><li class="filter" id="wiiu">Wii U</li></a>
            </ul>
        </aside>

<?php

print'<aside>';
    
    $columns = 7;
    $query = "SELECT fldGameName, fldSystem, fldAccount, fldName, fldDescription, fldDate, fldTime FROM tblEntries WHERE fldSystem = 'PS3' ORDER BY pmkDisplayOrder ";
    
    //$entries = $thisDatabaseReader->testquery($query, "", 1, 1, 2, 0, false, false);
    $entries = $thisDatabaseReader->select($query, "", 1, 1, 2, 0, false, false);
    $highlight = 0; // used to highlight alternate rows
//    print '<p>';
//    print 'SQL:';
//    print  $query;
//    print '<br>';
//    print 'TotalRecords=';
//    print count($entries);
//    print '</p>';
//    print'<table>';

    
    foreach ($entries as $entrie) {
        print"<aside class='$entrie[fldSystem]'>"
        . "<p class='game'>Game: $entrie[fldGameName]</p> <p class='system'>System: $entrie[fldSystem]</p>"
        . "<p class='account'>Account: $entrie[fldAccount]</p> <p class='name'>Name: $entrie[fldName]</p>"
        . "<p class='description'>$entrie[fldDescription]</p>"
        . "<p class='subTime'>$entrie[fldTime]</p>"
        . "<p class='subDate'>$entrie[fldDate]</p>"
        . "</aside>";
        
    }
    // all done
    print '</table>';
    print '</aside>';

include "footer.php";
?>