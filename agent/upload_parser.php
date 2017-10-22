<?php 
print_r( $_POST );

$fileName=$_FILES[ "file"][ "name"];
$fileTmpLoc=$_FILES[ "file"][ "tmp_name"];
$fileType=$_FILES[ "file"][ "type"];
$fileSize=$_FILES[ "file"][ "size"];
$fileErrorMsg=$_FILES[ "file"][ "error"];

if (!$fileTmpLoc) {
	echo "ERROR: Please browse for a file before clicking the upload button."; 
	exit(); 
} 
if(move_uploaded_file($fileTmpLoc, "test_uploads/$fileName")){ 
	echo "$fileName upload is complete"; 
} else { 
	echo "move_uploaded_file function failed"; 
} 

?>
