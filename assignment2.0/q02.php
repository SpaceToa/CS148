<?php
include "top.php";
$tableName = "";
?>
<ul>
    <li> q01: <a href="q01.php">SQL</a>  SELECT pmkNetId FROM tblTeachers</li>
    <li> q02: <a href="q02.php">SQL</a>  SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE "Introduction%"</li>
    <li> q03: <a href="q03.php">SQL</a>  SELECT * FROM tblSections WHERE fldStart = "13:10:00" AND fldBuilding = "KALKIN" </li>
    <li> q04: <a href="q04.php">SQL</a>  SELECT * FROM tblCourses WHERE fldCourseNumber="148" AND fldDepartment="CS"</li>
    <li> q05: <a href="q05.php">SQL</a>  SELECT fldFirstName fldLastName FROM tblTeachers WHERE pmkNetId LIKE "r%" AND pmkNetId LIKE "%o"</li>
    <li> q06: <a href="q06.php">SQL</a>  SELECT fldCourseName FROM tblCourses WHERE fldCourseName LIKE "%data%" AND fldDepartment!="CS" </li>
    <li> q07: <a href="q07.php">SQL</a>  SELECT fldDepartment FROM tblCourses GROUP BY fldDepartment</li>
    <li> q08: <a href="q08.php">SQL</a>  SELECT fldBuilding, COUNT(fldCRN) FROM tblSections GROUP BY fldBuilding</li>
    <li> q09: <a href="q09.php">SQL</a>  SELECT fldBuilding, COUNT(fldNumSTudents) FROM tblSections WHERE fldDays LIKE '%W%' GROUP BY fldBuilding DESC</li>
    <li> q10: <a href="q10.php">SQL</a>  SELECT fldBuilding, COUNT(fldNumSTudents) FROM tblSections WHERE fldDays LIKE '%F%' GROUP BY fldBuilding DESC</li>
</ul>
<?php
if (isset($_GET['getRecordsFor'])) {
    $query = $_GET['getRecordsFor'];
}
    //now print out each record
    
    print'<aside>';

    $columns = 1;
    $query = 'SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE "Introduction%"';                                                                                                                              
    //$info2 = $thisDatabaseReader->testquery($query, "", 1, 0, 2, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 0, 2, 0, false, false);
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