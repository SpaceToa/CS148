SELECT DISTINCT tblSections.fnkCourseId, fldFirstName, fldLastName FROM tblStudents INNER JOIN tblEnrolls ON tblStudents.pmkStudentId = tblEnrolls.fnkStudentID INNER JOIN tblSections ON tblEnrolls.fnkCourseId = tblSections.fnkCourseId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE tblSections.fnkCourseId = '392' ORDER BY fnkCourseId