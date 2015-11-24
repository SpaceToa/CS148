<?php
include "top.php";
$tableName = "";
?>

        <p> Welcome to the Burlington Bored Gamers Board! Ever wanted to play some multi-player video games, but you have no one to play with? Now you can post a listing looking for a playgroup, guild, or just a co-op buddy! Browse the latest postings below, filter by your console of choice, or make your own posting!</p>
        <h2> Current Postings </h2> 


        <!--   Console Filter buttons -->
        <aside>
            <ul>
                <li class="filter" id="all">All</li>
                <li class="filter" id="pc">PC</li>
                <li class="filter" id="x360">Xbox 360</li>
                <li class="filter" id="xbone">Xbox One</li>
                <li class="filter" id="ps3">PS3</li>
                <li class="filter" id="ps4">PS4</li>
                <li class="filter" id="n3ds">Nintendo 3DS</li>
                <li class="filter" id="wiiu">Wii U</li>
            </ul>
        </aside>

<?php

print'<aside>';
    
    $columns = 7;
    $query = "SELECT fldGameName, fldSystem, fldAccount, fldName, fldDescription, fldDate, fldTime FROM tblEntries ORDER BY pmkDisplayOrder ";
    
    //$entries = $thisDatabaseReader->testquery($query, "", 0, 1, 0, 0, false, false);
    $entries = $thisDatabaseReader->select($query, "", 0, 1, 0, 0, false, false);
    $highlight = 0; // used to highlight alternate rows
    print '<p>';
    print 'SQL:';
    print  $query;
    print '<br>';
    print 'TotalRecords=';
    print count($entries);
    print '</p>';
    print'<table>';
//    if($debug = TRUE){
//        foreach ($entries as $entrie) {
//            $highlight++;
//            if ($highlight % 2 != 0) {
//                $style = ' odd ';
//            } else {
//                $style = ' even ';
//            }
//            print '<tr class="' . $style . '">';
//            for ($i = 0; $i < $columns; $i++) {
//                print '<td>' . $entries[$i] . '</td>';
//            }
//            print '</tr>';
//        }
//    }
    
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