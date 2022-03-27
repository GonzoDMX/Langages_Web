<!-- TP 2 TELEVERSER UNI IMAGE - ANDREW O'SHEI -->
<!-- Langages Web - Master 1 Informatique -->
<html>
<head>
<link rel="stylesheet" href="user-styles.css">
</head>
<style>
	body {
	  text-align: center;
	}
</style>
<body>
<?php
// DISPLAY DEBUG MESSAGES
ini_set('display_errors',1);
error_reporting(E_ALL);
	
// Définir les paramètres de connexion à la base de données MySQL
$conn = mysqli_connect('localhost', 'andrew', '1mm1n3nt 5ympt0m 3xp05ure qu3nch Y3n');	
if(!$conn) {
	die("Cannot connect to MySQL DB: " . mysqli_connect_error());
} else {
	mysqli_select_db($conn, 'file_tree_db');
}
?>
<?php
	// GET THE ROOT IMAGE SOURCE DIRECTORY
	$get_root_path = "SELECT * FROM root LIMIT 1";
	$result = mysqli_query($conn, $get_root_path);
	while ($row = mysqli_fetch_array($result)) {
		// Définir la cible de recherche
		$path = $row["path"];
	}
?>
<?php
function get_categories( $path ) {
	if( $folder = opendir($path) ) {
		while( $entree = readdir($folder) ) {
			if( $entree != "." && $entree != ".." ) {
				$new_path = $path . "/" . $entree;
				if( is_dir($new_path) ) {
					echo "<option value='$new_path'>$entree</option>";
					get_categories( $new_path );
				}
			}
		}
		closedir($folder);
	}
}
?>
<h1 style="margin: 5px;">-- Image Gallery --</h1>
<div>
	<h2 style="margin: 0;">Upload Image File</h2>
	<form class="myForm" action="indexUser.php" method="POST" enctype="multipart/form-data">
		<label for="category">Image category :</label>
		<select id="category" name="category">
			<option value="<?php echo $path ?>">None</option>
			<?php
				get_categories( $path );
			?>
		</select>
		<input type="file" name="myFile" value="Choose File">
		<input type="submit" value="Upload">
	</form>
	<p>Maximum file size: 8Mo  -  Accepted file formatas: .jpg, .jpeg, .png</p>
	
<?php
	// FILE UPLOAD SCRIPT
	if(isset($_POST["category"])) {
		$parse_path = explode('/', $_POST["category"]);
		$parent = end($parse_path);
		$dest_dir = $_POST["category"] . '/';
	}

	// TEST IF THERE IS A FILE TO UPLOAD
	if (array_key_exists("myFile", $_FILES)) { 
		if (!empty($_FILES["myFile"]["name"])) {
			$file_path_info = pathinfo(basename($_FILES["myFile"]["name"]));
			$file_name = $file_path_info["filename"];
			$file_ext = strtolower($file_path_info["extension"]);
			$file_size = $_FILES["myFile"]["size"];
			
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
						$insert_query = "INSERT INTO files (name, parent, type, size, path) 
										VALUES( '$file_name', '$parent',
										'$file_ext', $file_size, '' )";
						$conn -> query($insert_query);
						$id = $conn -> insert_id;
						$dest_path = $dest_dir . $file_name . ".$file_ext";
						$conn -> query("UPDATE files SET path = '$dest_path' WHERE id = '$id'");
						
						if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $dest_path)) {
							header("Location:indexUser.php");
						} else {
							$conn -> query("DELETE files WHERE id = '$id'");
					  		echo "Upload failed, there was an error uploading your file.";
					  	}
					}
				}
			}
		}
	}
?>
<div class="usr-img-gallery">
<?php
	// -------- Algorithme de construction de table pour l'affichage d'images --------
	$row_limit = 8;
	$get_imgs = "SELECT * FROM files WHERE type IN ('jpg', 'jpeg', 'png')";
	if( isset($_POST["view"]) ) {
		if( $_POST["view"] !== $path ) {
			$tmp = explode('/', $_POST["view"]);
			$view = end($tmp);
			$get_imgs = $get_imgs . " AND parent='" . $view . "'";	
		}
	}
	
	$my_img = mysqli_query($conn, $get_imgs);
	$num_rows = mysqli_num_rows($my_img);
	$total_pages = ceil($num_rows / $row_limit);
	if(!isset ($_GET['page'])) {
		$page_number = 1;
	} else {
		$page_number = $_GET['page'];
	}
	$page_offset = ($page_number-1) * $row_limit;
	$lim_img = $get_imgs . " LIMIT " . $page_offset . ',' . $row_limit;
	$result = mysqli_query($conn, $lim_img);
	echo mysqli_error($conn);
	if ($num_rows > 0) {
		// Remplir le tableau avec des images
		echo '<table class="img-table" cellspacing="0" cellpadding="0">';
		$COUNTER = 1;
		while ($row = mysqli_fetch_array($result)) {
			if ($COUNTER == 1) {
				echo '<tr class="img-row">';
			}
			echo '<td class="img-col"><span class="img-span"><a href="" class="img-zoom">';
			// Si l'image est disponible localement, fournir un accès direct
			$ex_path = explode('%', $row["path"]);
			$ex_path = implode('%25', $ex_path);
			echo '<img class="img-img" src="/'. $ex_path . '">';
			echo '</a></span><div class="img-label"><table>';
			// Afficher les données d'image
			echo '<tr class="img-label"><p><strong>File Name :</strong> ',$row['name'],'</p></tr>';
			if ($row['size'] > 1000000) {
				$tmp_size = round($row['size'] / 1000000, 2, PHP_ROUND_HALF_UP);
				echo '<tr class="img-label"><p><strong>Size :</strong> ',$tmp_size,'MB</p></tr>';
			} else {
				$tmp_size = round($row['size'] / 1000, 2, PHP_ROUND_HALF_UP);
				echo '<tr class="img-label"><p><strong>Size :</strong> ',$tmp_size,'kB</p>';
			}
			echo '</tr>';
			echo '</table></div>';
			echo '</td>';
			
			if ($COUNTER == ($row_limit / 2)) {
				echo '</tr>';
				$COUNTER = 0;
			}
			$COUNTER = $COUNTER + 1;
		}
		echo '</table>';
	// --------
?>	
</div>
<div>
	<form class="myForm" action="indexUser.php" method="POST" enctype="multipart/form-data">
		<label for="view">Display image category :</label>
		<select id="view" name="view">
			<option value="<?php echo $path; ?>">All</option>
			<?php
				get_categories($path );
			?>
		</select>
		<input type="submit" value="Update">
	</form>	
<?php	
		// -------- Algorithme de PAGINATION --------
		echo "<h3 style='margin: 5px;'>Current Page: $page_number</h3>";
		if ($total_pages > 1) {
			echo '<div>';
			// Si la page actuelle est supérieure à 1
			if ($page_number > 1) {
				// Activer le bouton de retour de page
				echo '<a class="page-num" href = "indexUser.php?page=', ($page_number - 1), '"><</a>';
			}
			// Sinon
			else {
				// Desactiver le bouton de retour de page
				echo '<a class="page-num"><</a>';
			}
			// Pour le nombre total de pages
			for($counter = 1; $counter<= $total_pages; $counter++) {
				if ($counter == $page_number) {
					echo "<a class='page-num'>$counter</a>";
				} else {
					// Ajouter un bouton pour chaque page
					echo '<a class="page-num" href = "indexUser.php?page=', $counter, '">', $counter, '</a>';
				}
			}
			// Si la page actuelle n'est pas la dernière page
			if ($page_number != $total_pages) {
				// Activer le bouton de page suivante
				echo '<a class="page-num" href = "indexUser.php?page=', ($page_number + 1), '">></a>';
			}
			// Sinon
			else {
				// Desactiver le bouton de page suivante
				echo '<a class="page-num">></a>';
			}
		}
		// --------
}
?>
</div>
</body>
</html>
