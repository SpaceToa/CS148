<?php
include "top.php";
$tableName = "";
if (isset($_GET['getRecordsFor'])) {
    $tableName = $_GET['getRecordsFor'];
}
    //now print out each record
    
    print'<aside>';
    print'<table>';
    $columns = 1;
    $query = 'SELECT pmkNetID FROM tblTeachers';
    //$info2 = $thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $highlight = 0; // used to highlight alternate rows
    print '<p>';
    print 'SQL:';
    print  $query;
    print '</br>';
    print 'TotalRecords';
    print count($info2);
    print '</p>';
    
    foreach ($info2 as $rec) {
        $highlight++;
        if ($highlight % 2 != 0) {
            $style = ' odd ';
        } else {
            $style = ' even ';
        }
        print '<tr class="' . $style . '">';
        for ($i = 0; $i < $columns; $i++) {
            print '<td>' . $rec[$i] . '</td>';
        }
        print '</tr>';
    }
    // all done
    print '</table>';
    print '</aside>';

print '</article>';
include "footer.php";
?>