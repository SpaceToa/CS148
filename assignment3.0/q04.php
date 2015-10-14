<?php
include "top.php";
$tableName = "";
?>
<ul>
    <li> q01: <a href="q01.php">SQL</a>  SELECT DISTINCT fldCourseName FROM tblCourses, tblEnrolls WHERE tblEnrolls.fldGrade = 100 AND pmkCourseId = fnkCourseId ORDER BY fldCourseName</li>
    <li> q02: <a href="q02.php">SQL</a>  SELECT DISTINCT fldDays, fldStart, fldStop FROM tblTeachers INNER JOIN tblSections ON tblTeachers.pmkNetId = tblSections.fnkTeacherNetId WHERE fldLastName='Snapp' AND fldFirstName = 'Robert Raymond' ORDER BY fldStart</li>
    <li> q03: <a href="q03.php">SQL</a>  SELECT DISTINCT fldCourseName, fldDays, fldStart, fldStop FROM tblTeachers INNER JOIN tblSections ON tblTeachers.pmkNetId = tblSections.fnkTeacherNetId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE fldLastName='Horton' AND fldFirstName = 'Jackie Lynn' ORDER BY fldStart </li>
    <li> q04: <a href="q04.php">SQL</a>  SELECT DISTINCT tblSections.fnkCourseId, fldFirstName, fldLastName FROM tblStudents INNER JOIN tblEnrolls ON tblStudents.pmkStudentId = tblEnrolls.fnkStudentID INNER JOIN tblSections ON tblEnrolls.fnkCourseId = tblSections.fnkCourseId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE tblSections.fnkCourseId = '392' ORDER BY fnkCourseId</li>
    <li> q05: <a href="q05.php">SQL</a>  SELECT tblTeachers.fldFirstName, tblTeachers.fldLastName,  count(tblStudents.fldFirstName) AS total FROM tblSections JOIN tblEnrolls ON tblSections.fldCRN  = tblEnrolls.`fnkSectionId` JOIN tblStudents ON pmkStudentId = fnkStudentId JOIN tblTeachers ON tblSections.fnkTeacherNetId=pmkNetId WHERE fldType != "LAB" GROUP BY fnkTeacherNetId ORDER BY total DESC</li>
    <li> q06: <a href="q06.php">SQL</a>  SELECT fldFirstName, fldPhone, fldSalary FROM tblTeachers WHERE fldSalary < (SELECT avg(fldSalary) FROM tblTeachers) </li>
    <li> q07: <a href="q07.php">SQL</a>  </li>
    <li> q08: <a href="q08.php">SQL</a>  </li>
</ul>
<?php
if (isset($_GET['getRecordsFor'])) {
    $query = $_GET['getRecordsFor'];
}
    //now print out each record
    
    print'<aside>';

    $columns = 3;
    $query = 'SELECT DISTINCT tblSections.fnkCourseId, fldFirstName, fldLastName FROM tblStudents INNER JOIN tblEnrolls ON tblStudents.pmkStudentId = tblEnrolls.fnkStudentID INNER JOIN tblSections ON tblEnrolls.fnkCourseId = tblSections.fnkCourseId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE tblSections.fnkCourseId = "392" ORDER BY fnkCourseId';
    //$info2 = $thisDatabaseReader->testquery($query, "", 1, 1, 2, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 1, 2, 0, false, false);
    $highlight = 0; // used to highlight alternate rows
    print '<p>';
    print 'SQL:';
    print  $query;
    print '<br>';
    print 'TotalRecords= ';
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