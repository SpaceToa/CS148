<?php
include "top.php";
$tableName = "";
?>

<?php

print'<aside>';
    
    $columns = 12;
    $query = 'SELECT pmkPlanID, fldDateCreate, fldCatalogYear, fnkStudentNetID, `fnkAdvisorNetID`, pmkYear, pmkTerm, fnkCourseID, pmkCourseId, fldDepartment, fldCredits, fldCourseNumber
FROM tblPlan 

JOIN tblSemesterPlan on pmkPlanID = fnkPlanID 

JOIN tblSemesterPlanCourses on tblSemesterPlan.fnkPlanID = tblSemesterPlanCourses.fnkPlanID 
AND pmkYear = fnkYear 
AND pmkTerm = fnkTerm 

JOIN tblCourses on tblSemesterPlanCourses.fnkCourseID = tblCourses.pmkCourseId

WHERE pmkPlanID = 00001

ORDER BY tblSemesterPlan.fldDisplayOrder, tblSemesterPlanCourses.fldDisplayOrder';
    
    $info2 = $thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $highlight = 0; // used to highlight alternate rows
    print '<p>';
    print 'SQL:';
    print  $query;
    print '<br>';
    print 'TotalRecords=';
    print count($info2);
    print '</p>';
    print'<table>';
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

include "footer.php";
?>