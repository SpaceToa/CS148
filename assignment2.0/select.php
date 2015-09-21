<?php
include "top.php";
$tableName = "";
?>
<ul>
    <li> q01: <a href="sqlQs/q01.sql">SQL</a>  SELECT pmkNetId FROM tblTeachers</li>
    <li> q02: <a href="sqlQs/q02.sql">SQL</a>  SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE "Introduction%"</li>
    <li> q03: <a href="sqlQs/q03.sql">SQL</a>  SELECT </li>
    <li> q04: <a href="sqlQs/q04.sql">SQL</a>  SELECT * FROM tbleCourses WHERE fldCourseNumber="148" AND fldDepartment="CS"</li>
    <li> q05: <a href="sqlQs/q05.sql">SQL</a>  SELECT </li>
    <li> q06: <a href="sqlQs/q06.sql">SQL</a>  SELECT </li>
    <li> q07: <a href="sqlQs/q07.sql">SQL</a>  SELECT </li>
    <li> q08: <a href="sqlQs/q08.sql">SQL</a>  SELECT </li>
    <li> q09: <a href="sqlQs/q09.sql">SQL</a>  SELECT </li>
    <li> q10: <a href="sqlQs/sq10.sql">SQL</a>  SELECT </li>
</ul>
<?php
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