SELECT DISTINCT fldCourseName, fldDays, fldStart, fldStop FROM tblTeachers INNER JOIN tblSections ON tblTeachers.pmkNetId = tblSections.fnkTeacherNetId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE fldLastName='Horton' AND fldFirstName = 'Jackie Lynn' ORDER BY fldStart