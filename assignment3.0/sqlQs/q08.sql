/*Display each building name and the number of sections it has (___)*/
$query = SELECT fldBuilding, COUNT(CRN), FROM tblSections GROUP BY fldBuilding;