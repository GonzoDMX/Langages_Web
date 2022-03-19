<!-- TP 2 TELEVERSER UNI IMAGE - ANDREW O'SHEI -->
<!-- Langages Web - Master 1 Informatique -->
<html>
<style>
	body {
	  height: 90vh;
	  font-family: 'Courier New', monospace;
	  text-align: center;
	}
	table {
		margin-left: auto;
		margin-right: auto;
	}
	tr td {
		border: 1px solid black;
		padding: 5px;
	}
	a {
		font-size: 32;
		margin-left: 5px;
		margin-right: 5px;
	}
    li {
    	display:inline-block;
    }
    img {
        object-fit: cover;
		width: 250px;
		height: 250px;
    }
	ul li a:hover img {
		object-fit: scale-down;
		transform: scale(2);
	}
	.pagin-div {
		display: inline-block;
		border: 1px solid black;
		padding: 15px;
	}
</style>
<body>
	<?php
		// DISPLAY DEBUG MESSAGES
		ini_set('display_errors',1);
		error_reporting(E_ALL);
		
		// ACCESS DATABASE HERE
		$conn = mysqli_connect('localhost', 'andrew', 'lets give it another go');
		
		if(!$conn) {
			die("Connot connect to SQL Database: " . mysqli_connect_error());
		} else {
			mysqli_select_db($conn, 'my_images');
		}
		$row_limit = 8;
		$get_data = "SELECT * FROM images";
		$result = mysqli_query($conn, $get_data);
		$num_rows = mysqli_num_rows($result);
		$total_pages = ceil($num_rows / $row_limit);
		if(!isset ($_GET['page'])) {
			$page_number = 1;
		} else {
			$page_number = $_GET['page'];
		}
		$page_offset = ($page_number-1) * $row_limit;
		$get_data = "SELECT * FROM images ORDER BY id DESC LIMIT $page_offset , $row_limit";
		$result = mysqli_query($conn, $get_data);
	?>
	
	<h1>PHP Image Viewer</h1>
	<div>
		<h2>Upload Image File</h2>
		<form class="myForm" action="tele_form.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="myFile" value="Choose File">
			<input type="submit" value="Upload">
		</form>
		<p>Maximum file size: 8Mo  -  Accepted file formatas: .jpg, .jpeg, .png</p>
		
	<?php
		// FILE UPLOAD SCRIPT
		$dest_dir = "images/";
		$deja_files = glob($dest_dir . "*");
		$file_count = count($deja_files) + 1;
		// TEST IF THERE IS A FILE TO UPLOAD
		if (array_key_exists("myFile", $_FILES)) { 
			if (!empty($_FILES["myFile"]["name"])) {
				$file_path_info = pathinfo(basename($_FILES["myFile"]["name"]));
				$file_name = $file_path_info["filename"];
				$file_ext = strtolower($file_path_info["extension"]);
				$file_size = $_FILES["myFile"]["size"];
				$dest_path = $dest_dir . $file_count . ".$file_ext";
				
				// Vérifier les erreurs
				if($_FILES["myFile"]["error"] > 2) {
					echo "Upload failed, there has been an error.";
				}
				else {
					// Vérifier la taille du fichier
					if ($_FILES["myFile"]["size"] > 8388608) {
					  echo "Upload failed, file size exceeds 8Mb.";
					}
					else {
						// Vérifier le type de fichier
						if($file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "png" ) {
							echo "Upload failed, file must be type 'jpg', 'jpeg' or 'png'.";
						}
						else {
							// Televerser le fichier
							if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $dest_path)) {
								$insert_query = "INSERT INTO images (id, name, type, size) 
											VALUES( $file_count , '$file_name' , '$file_ext', $file_size )";
								if ($conn->query($insert_query) === TRUE) {
									echo "File uploaded successfully !";
								} else {
									echo "Upload failed, unable to connect to database.";
								}
								header("Location:tele_form.php");
							} else {
						  		echo "Upload failed, there was an error uploading your file.";
						  	}
						}
					}
				}
			}
		}
	?>
	</div>
	<div>
		<?php
			if ($num_rows > 0) {
				// POPULATE TABLE WITH IMAGES
				echo '<table>';
				$COUNTER = 1;
				while ($row = mysqli_fetch_array($result)) {
					$my_path = $dest_dir . $row['id'] . '.' . $row['type'];
					if ($COUNTER == 1) {
						echo '<tr>';
					}
					echo '<td><ul><li><a href=""><img ';
					echo 'src="' . $my_path . '"></a></li></ul><table>';
					echo '<tr class="row-label"><p>Filename: ' . $row['name'] . '.' . $row['type'] . '</p></tr>';
					if ($row['size'] > 1000000) {
						$tmp_size = round($row['size'] / 1000000, 2, PHP_ROUND_HALF_UP);
						echo '<tr class="row-label"><p>Size: ' . $tmp_size . 'MB</p></tr>';
					} else {
						$tmp_size = round($row['size'] / 1000, 2, PHP_ROUND_HALF_UP);
						echo '<tr class="row-label"><p>Size: ' . $tmp_size . 'kB</p></tr>';
					}
					echo '<tr class="row-label"><p>Date: ' . $row['dt'] . '</p></tr>';
					echo '</table>';
					echo '</td>';
					if ($COUNTER == 4) {
						echo '</tr>';
						$COUNTER = 0;
					}
					$COUNTER = $COUNTER + 1;
				}
				echo '</table>';
				
				
				// PAGINATION SCRIPT
				if ($total_pages > 1) {
					echo '<div class="pagin-div">';
					// Si la page actuelle est supérieure à 1
					if ($page_number > 1) {
						// Activer le bouton de retour de page
						echo '<a href = "tele_form.php?page=' . ($page_number - 1) . '"><</a>';
					}
					// Sinon
					else {
						// Desactiver le bouton de retour de page
						echo '<a><</a>';
					}
					// Pour le nombre total de pages
					for($counter = 1; $counter<= $total_pages; $counter++) {
						// Ajouter un bouton pour chaque page
						echo '<a href = "tele_form.php?page=' . $counter . '">' . $counter . '</a>';
					}
					// Si la page actuelle n'est pas la dernière page
					if ($page_number != $total_pages) {
						// Activer le bouton de page suivante
						echo '<a href = "tele_form.php?page=' . ($page_number + 1) . '">></a>';
					}
					// Sinon
					else {
						// Desactiver le bouton de page suivante
						echo '<a>></a>';
					}
				}
			}
		?>
	</div>
</body>
</html>
