<!DOCTYPE html>
<html>
<body>

<form action="processing.php" method="post" enctype="multipart/form-data">
    Select csv file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
	<br/>
	<br/>
	Column number of UPC
	<input type="text" name="upc_column" required />
	<br/>
	<br/>
    <input type="submit" value="Upload File" name="submit">
</form>

</body>
</html>
