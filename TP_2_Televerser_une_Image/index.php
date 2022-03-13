<!-- TP 2 TELEVERSER UNI IMAGE - ANDREW O'SHEI -->
<!-- Langages Web - Master 1 Informatique -->
<html>
<style>
</style>
<body>
	<h1>Upload Image File</h1>
	<form class="myForm" action="televerser.php" method="POST" enctype="multipart/form-data">
		<input type="file" id="myFile" name="myFile" value="Choose File">
		<input type="submit" value="Upload">
	</form>
	<p>Accepted file formatas: .jpg, .jpeg, .png</p>
	<p>Maximum file size: 8Mo</p>
</body>
</html>
