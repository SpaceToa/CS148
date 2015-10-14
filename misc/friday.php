<?php
    include "top.php";

    print '<table>';
    $columns = 8;
    //now print out each record
    $query = 'SELECT fldFirstName, fldLastName, pmkStudentId, fldStreetAddress, fldCity, fldState, fldZip, fldGender FROM tblStudents ORDER BY fldLastName, fldFirstName LIMIT 10 OFFSET 1000';
    $info2 = $thisDatabaseReader->select($query, "",0, 1, 0, 0, false, false);
    
    
    $query2 = 'SELECT fldFirstName, fldLastName, pmkStudentId, fldStreetAddress, fldCity, fldState, fldZip, fldGender FROM tblStudents ORDER BY fldLastName, fldFirstName';
    $countinfo2 = $thisDatabaseReader->select($query2, "",0, 1, 0, 0, false, false);

    print'<p>' . count($countinfo2) . '</p>';
    
    $highlight = 0; // used to highlight alternate rows

    $fields = array_keys($info2[0]);
    $labels = array_filter($fields,"is_string");
    //print "<p><pre>";
    //print_r($fields);

    print '<tr>';
    foreach ($labels as $label){
        $camelCase = preg_split('/(?=[A-Z])/', substr($label, 3));
        $message = "";
        foreach ($camelCase as $one) {
            $message .= $one . " ";
        }
        print '<th>';
        print $message;
        print '</th>';
    }
    print '</tr>';
    //print '<tr>';
    //print '<th>First name</th><th>Last Name</th><th>StudentId</th><th>Street Address</th><th>City</th><th>State</th><th>Zip</th><th>Gender</th>';
    //print '</tr>';
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