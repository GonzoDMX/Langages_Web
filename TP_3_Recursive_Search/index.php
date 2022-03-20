<html>
<style>
body {
	height: 90vh;
}
ul {
	list-style-type: none;
}
.directr {
	cursor: pointer;
	font-weight: bold;
}

.directr::before {
	content: "\1F4C1";
	margin-right: 8px;
}
.caret-down::down {
	content: "\1F4C2";
}
.filels::before {
	content: "\1F4C4";
	margin-right: 8px;
}
.img-file::before {
	content: "\1F4F7";
	margin-right: 8px;
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
img {
    object-fit: cover;
	width: 250px;
	height: 250px;
}
ul li a:hover img {
	object-fit: scale-down;
	transform: scale(2);
}
.file-tree {
	float: left;
	width: 30%;
	height: 100%;
	padding-left: 5%;
}
.img-gallery {
	float: right;
	width: 60%;
	height: 100%;
	text-align: center;
}
</style>
<body>
<?php
// ACCESS DATABASE HERE
$conn = mysqli_connect('localhost', 'andrew', 'lets give it another go');
		
if(!$conn) {
	die("Cannot connect to MySQL DB: " . mysqli_connect_error());
} else {
	mysqli_select_db($conn, 'file_tree_db');
	mysqli_query($conn, "DELETE FROM directories" );
	mysqli_query($conn, "DELETE FROM files" );
}
	
// Définir le nombre de secondes pendant lesquelles le script est
// autorisé à s'exécuter, Dans ce cas 500 secondes.
set_time_limit (500);
$path= "docs";

// Envoyer le chemin du répertoire, défini dans la variable $path,
// comme argument à la fonction exploreDir().
explorerDir($path, $conn);

function explorerDir($path, $conn)
{
	// Créer un handle pour le répertoire $path
	// Cela permet les commandes:
	// 		closedir() - fermer le handle
	//		readdir() - récupérer le nom de l'élément suivant dans un répertoire
	//		rewinddir() - retourner à la racine du répertoire defini dans le handle
	$folder = opendir($path);
	
	// Continuez la boucle pendant que readdir() renvoie un nom valide
	// à partir du handle de répertoire $folder
	while($entree = readdir($folder))
	{	
		
		// Vérifier si $entree est une référence au répertoire courant ou au
		// répertoire précédent. Si c'est une telle référence, sautez-la.
		if($entree != "." && $entree != "..")
		{
			//echo "<p>$path/$entree</p>";
			// Vérifier si la variable $entree pointe vers un fichier ou un répertoire.
			if(is_dir($path."/".$entree))
			{
				// Stocker temporairement le chemin racine afin qu'il ne soit pas
				// perdu lors de l'opération suivante.
				$sav_path = $path;
				
				// Former un nouveau chemin de répertoire en ajoutant $entree à $path.
				$path .= "/".$entree;
				
				// Get Data for database
				$tmp = explode("/", $path);
				$ind = count($tmp) - 2;
				$parent = $tmp[$ind];
				
				$insert_dir = "INSERT INTO directories (name, parent, path) VALUES('$entree', '$parent', '$path')";
				if (mysqli_query($conn, $insert_dir) !== TRUE) {
					echo "Failed to write to DB.";
				}

				// Appele la fonction explorerDir() de manière récursive
				// avec le nouveau chemin.
				explorerDir($path, $conn);
				
				// Restaurer le chemin racine en tant que variable $path.
				$path = $sav_path;
			}
			else
			{
				// Si la variable $entry pointe vers un fichier écriver son chemin
				// complet vers la variable $path_source.
				$path_source = $path."/".$entree;				
				
				$tmp = explode("/", $path_source);
				$ind = count($tmp) - 2;
				$parent = $tmp[$ind];
				$ext = pathinfo($path_source, PATHINFO_EXTENSION);
				$size = filesize($path_source);
				
				$insert_file = "INSERT INTO files (name, parent, type, size, path) VALUES('$entree', '$parent', '$ext', '$size', '$path_source')";
				if (mysqli_query($conn, $insert_file) !== TRUE) {
					echo "Failed to write to DB.";
				}
			}
		}
	}
	closedir($folder);
}
?>
<div class="file-tree">
	<h1>File Tree</h1>
	<ul>
	<?php
	function draw_file_tree($root, $conn) {
		// Get all file names in DIR
		$get_files = "SELECT name, type FROM files WHERE parent='$root'";
		$my_files = mysqli_query($conn, $get_files);
		// Get all sub dirs in DIR
		$get_subdir = "SELECT name FROM directories WHERE parent='$root'";
		$my_subdir = mysqli_query($conn, $get_subdir);
		echo "<li><span class='directr'>$root</span>";
		echo "<ul class='sub-dir'>";
		while ($row = mysqli_fetch_array($my_files)) {
			if($row["type"] === 'jpg' || $row["type"] === 'jpeg' || $row["type"] === 'png') {
				echo '<li class="img-file">' . $row["name"] . '</li>';
			} else {
				echo '<li class="filels">' . $row["name"] . '</li>';
			}
		}
		while ($row = mysqli_fetch_array($my_subdir)) {
			draw_file_tree($row["name"], $conn);
		}
		echo "</ul>";
	}
	draw_file_tree($path, $conn);
	?>
	</ul>
</div>
<div class="img-gallery">
<h1>Image Gallery</h1>
<h2>A collection of the images found in file tree</h2>
<?php
	$row_limit = 6;
	$get_all = "SELECT * FROM files WHERE type IN ('jpg', 'jpeg', 'png')";
	$my_img = mysqli_query($conn, $get_all);
}
	$num_rows = mysqli_num_rows($my_img);
	$total_pages = ceil($num_rows / $row_limit);
	if(!isset ($_GET['page'])) {
		$page_number = 1;
	} else {
		$page_number = $_GET['page'];
	}
	$page_offset = ($page_number-1) * $row_limit;
	$lim_img = $get_all . " LIMIT " . $page_offset . ',' . $row_limit;
	$result = mysqli_query($conn, $lim_img);
	if ($num_rows > 0) {
		// POPULATE TABLE WITH IMAGES
		echo '<table>';
		$COUNTER = 1;
		while ($row = mysqli_fetch_array($result)) {
			$my_path = $row["path"];
			if ($COUNTER == 1) {
				echo '<tr>';
			}
			echo '<td><ul><li><a href=""><img ';
			echo 'src="' . $my_path . '"></a></li></ul><table>';
			echo '<tr class="row-label"><p>Filename: ' . $row['name'] . '</p></tr>';
			if ($row['size'] > 1000000) {
				$tmp_size = round($row['size'] / 1000000, 2, PHP_ROUND_HALF_UP);
				echo '<tr class="row-label"><p>Size: ' . $tmp_size . 'MB</p></tr>';
			} else {
				$tmp_size = round($row['size'] / 1000, 2, PHP_ROUND_HALF_UP);
				echo '<tr class="row-label"><p>Size: ' . $tmp_size . 'kB</p></tr>';
			}
			echo '</table>';
			echo '</td>';
			if ($COUNTER == 3) {
				echo '</tr>';
				$COUNTER = 0;
			}
			$COUNTER = $COUNTER + 1;
		}
		echo '</table>';
		
		echo "<h3>Current Page: $page_number</h3>";
		// PAGINATION SCRIPT
		if ($total_pages > 1) {
			echo '<div class="pagin-div">';
			// Si la page actuelle est supérieure à 1
			if ($page_number > 1) {
				// Activer le bouton de retour de page
				echo '<a href = "index.php?page=' . ($page_number - 1) . '"><</a>';
			}
			// Sinon
			else {
				// Desactiver le bouton de retour de page
				echo '<a><</a>';
			}
			// Pour le nombre total de pages
			for($counter = 1; $counter<= $total_pages; $counter++) {
				// Ajouter un bouton pour chaque page
				echo '<a href = "index.php?page=' . $counter . '">' . $counter . '</a>';
			}
			// Si la page actuelle n'est pas la dernière page
			if ($page_number != $total_pages) {
				// Activer le bouton de page suivante
				echo '<a href = "index.php?page=' . ($page_number + 1) . '">></a>';
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
