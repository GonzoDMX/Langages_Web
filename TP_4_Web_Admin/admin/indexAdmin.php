<html>
<head>
<head>
<link rel="stylesheet" href="../user-styles.css">
</head>
<style>
</style>
<body>
<?php
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);
// Démarrer la session, permet la conservation des variables lors des rechargements de page
session_start();


// Définir les paramètres de connexion à la base de données MySQL
$conn = mysqli_connect('localhost', 'andrew', '1mm1n3nt 5ympt0m 3xp05ure qu3nch Y3n');	
if(!$conn) {
	die("Cannot connect to MySQL DB: " . mysqli_connect_error());
} else {
	mysqli_select_db($conn, 'file_tree_db');
}
?>
<?php
	// -------- SUPPRESSION D'UNE IMAGE --------
	// Recuperation de l'ID avec $_GET
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		mysqli_query($conn, "DELETE FROM files WHERE id=$id");
	}
?>
<?php
// Définir le nombre de secondes pendant lesquelles le script est
// autorisé à s'exécuter, Dans ce cas 500 secondes.
set_time_limit (500);

// GET THE ROOT IMAGE SOURCE DIRECTORY
$get_root_path = "SELECT * FROM root LIMIT 1";
$result = mysqli_query($conn, $get_root_path);
while ($row = mysqli_fetch_array($result)) {
	// Définir la cible de recherche
	$path = $row["path"];
	$rel_path = "../" . $row["path"];
}

// Définir le filtre de recherche
$filter = "";
if(isset($_POST['myFilter'])) {
	$filter = $_POST['myFilter'];
	$_SESSION['myFilter'] = $filter;
} elseif (isset($_SESSION['myFilter'])) {
	$filter = $_SESSION['myFilter'];
}

// Vérifier si une recherche doit être lancée
if(isset($_POST['trigSearch'])) {
	$_SESSION['search'] = $_POST['trigSearch'];
}
if(!isset($_SESSION['search'])) {
	$_SESSION['search'] === "TRUE";
}
// Si nous lançons une nouvelle recherche, effacer la base de données
if($_SESSION['search'] === "TRUE") {
	if(isset($_POST['rootDir'])) {
		$path = $_POST['rootDir'];
		mysqli_query($conn, "DELETE FROM root" );
		$insert_root = "INSERT INTO root (path) VALUES('$path')";
		if (mysqli_query($conn, $insert_root) !== TRUE) {
			echo "<p>Failed to write root path to DB.</p>";
		}
	}
	mysqli_query($conn, "DELETE FROM directories" );
	mysqli_query($conn, "DELETE FROM files" );
	
	// Envoyer le chemin du répertoire, défini dans la variable $path,
	// comme argument à la fonction exploreDir().
	explorerDir($path, $conn, $filter, TRUE);
	$_SESSION['search'] = "FALSE";
}
// -------- Fonction de recherche récursive --------
function explorerDir($path, $conn, $filter, $first) {
	// Créer un handle pour le répertoire $path
	// Cela permet les commandes:
	// 		closedir() - fermer le handle
	//		readdir() - récupérer le nom de l'élément suivant dans un répertoire
	//		rewinddir() - retourner à la racine du répertoire defini dans le handle
	if($folder = opendir("../" . $path)) {
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
				if(is_dir("../" . $path."/".$entree))
				{
					// Stocker temporairement le chemin racine afin qu'il ne soit pas
					// perdu lors de l'opération suivante.
					$sav_path = $path;
					
					// Former un nouveau chemin de répertoire en ajoutant $entree à $path.
					$path .= "/".$entree;
					
					// Définir le parent du fichier comme $path si nous sommes toujours
					// dans le répertoire racine
					if($first) {
						$parent = $sav_path;
					} else {
						// Déconstruire $path et trouver le nom du parent
						$tmp = explode("/", $path);
						$ind = count($tmp) - 2;
						$parent = $tmp[$ind];
					}
					// Créer une entrée pour le répertoire dans la base de données MySQL
					$insert_dir = "INSERT INTO directories (name, parent, path) VALUES('$entree', '$parent', '$path')";
					if (mysqli_query($conn, $insert_dir) !== TRUE) {
						echo "<p>$entree : Failed to write to DB.</p>";
					}

					// Appele la fonction explorerDir() de manière récursive
					// avec le nouveau chemin.
					explorerDir($path, $conn, $filter, FALSE);
					
					// Restaurer le chemin racine en tant que variable $path.
					$path = $sav_path;
				}
				else
				{
					// Passer le nom du fichier à travers le filtre de recherche
					if(empty($filter) || strpos($entree, $filter) !== FALSE) {
						// Si la variable $entry pointe vers un fichier écriver son chemin
						// complet vers la variable $path_source.
						$path_source = $path."/".$entree;				
						
						// Définir le parent du fichier comme $path si nous sommes toujours
						// dans le répertoire racine
						if($first) {
							$parent = $path;
						} else {
						// Déconstruire $path_source et trouver le nom du parent
							$tmp = explode("/", $path_source);
							$ind = count($tmp) - 2;
							$parent = $tmp[$ind];
						}
						// Obtenir la taille et l'extension du fichier
						$ext = pathinfo("../" . $path_source, PATHINFO_EXTENSION);
						$size = filesize("../" . $path_source);
						
						// Créer une entrée pour le fichier dans la base de données MySQL
						$insert_file = "INSERT INTO files (name, parent, type, size, path) VALUES('$entree', '$parent', '$ext', '$size', '$path_source')";
						if (mysqli_query($conn, $insert_file) !== TRUE) {
							echo "<p>$entree : Failed to write to DB.</p>";
						}
					}
				}
			}
		}
		closedir($folder);
	}
}
// --------
?>
<div class="admin-div">
	<h1 style="margin: 0;">Admin Page</h1>
<!-- Formulaire, pour définir la cible et le filtre pour la recherche -->
<div class="tree-nav">
	<h2>Image Source</h2>
	<form  class="myForm" action="indexAdmin.php" method="POST">
		<label class="fLabel" for="rootDir">Source directory :</label>
		<input class="tInput" type="text" id="rootDir" name="rootDir" value=<?php echo $path; ?>><br>
		<label class="fLabel" for="myFilter">Filter source by :</label>
		<input type="hidden" id="trigSearch" name="trigSearch" value="TRUE">
		<input class="tInput" type="text" id="myFilter" name="myFilter" value=<?php echo $filter; ?>><br>
		<input id="submit-btn" type="submit" value="Update Source">
	</form>
	<div class="tree-view">
		<ul class="tree-list">
		<?php
		$spacer = 0;
		// --------- Algorithme de reconstruction de l'arborescence des répertoires --------
		function draw_file_tree( $root, $conn, $carry ) {
			// Global constant used to maintain value through recursions
			global $spacer;
			// CONSTANT OFFSETS FOR DIR AND FILE SPACE
			$dirSpace = 245;
			$fileSpace = 170;
			// Obtenir tous les noms de fichiers dans le répertoire $root
			$get_files = "SELECT name, type FROM files WHERE parent='$root'";
			$my_files = mysqli_query($conn, $get_files);
			// Obtenir tous les sous-répertoires du répertoire $root
			$get_subdir = "SELECT name FROM directories WHERE parent='$root'";
			$my_subdir = mysqli_query($conn, $get_subdir);

			$offset = $spacer - $carry + $dirSpace;
			echo "<li class='item' style='--my-height: ",$offset,"%;'><span><a class='dir-icon'></a>$root</span>";
			$spacer = $spacer + $dirSpace;
			echo "<ul class='sub-menu' style='--my-height: 200%;'>";

			// Lister les fichier et ajouter une étiquette de type de fichier
			while ($row = mysqli_fetch_array($my_files)) {
				if($row["type"] === 'jpg' || $row["type"] === 'jpeg' || $row["type"] === 'png') {
					echo '<li class="item"><span><a class="image-icon"></a>', $row["name"], '</span></li>';
				} else {
					echo '<li class="item"><span><a class="file-icon"></a>', $row["name"], '</span></li>';
				}
				$spacer = $spacer + $fileSpace;
			}

			$carry = $spacer;
			while ($row = mysqli_fetch_array($my_subdir)) {
				draw_file_tree( $row["name"], $conn, $carry );
			}
			echo "</li>";
			echo "</ul>";
		}
		draw_file_tree($path, $conn, 245);
		?>
		</ul>
	</div>
</div>
<div class="img-gallery">
	<h2 style="margin: 5px;">Image Gallery</h2>
	<h3 style="margin: 3px;">A collection of the images found in file tree</h3>
	<?php
		// -------- Algorithme de construction de table pour l'affichage d'images --------
		$row_limit = 6;
		$get_all_imgs = "SELECT * FROM files WHERE type IN ('jpg', 'jpeg', 'png')";
		$my_img = mysqli_query($conn, $get_all_imgs);
		$lim_img = $get_all_imgs . " LIMIT ";
		$num_rows = mysqli_num_rows($my_img);
		$total_pages = ceil($num_rows / $row_limit);
		if(!isset ($_GET['page'])) {
			$page_number = 1;
		} else {
			$page_number = $_GET['page'];
		}
		$page_offset = ($page_number-1) * $row_limit;
		$lim_img = $lim_img . $page_offset . ',' . $row_limit;
		$result = mysqli_query($conn, $lim_img);
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
				echo '<img class="img-img" src="../'. $ex_path . '">';
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
				echo '</table><a class="button" href="?id=' , $row['id'] , '">Remove</a></div>';
				echo '</td>';
				
				if ($COUNTER == 3) {
					echo '</tr>';
					$COUNTER = 0;
				}
				$COUNTER = $COUNTER + 1;
			}
			echo '</table>';
		// --------
			
			
			// -------- Algorithme de PAGINATION --------
			echo "<h3 style='margin: 5px;'>Current Page: $page_number</h3>";
			if ($total_pages > 1) {
				echo '<div>';
				// Si la page actuelle est supérieure à 1
				if ($page_number > 1) {
					// Activer le bouton de retour de page
					echo '<a class="page-num" href = "indexAdmin.php?page=', ($page_number - 1), '"><</a>';
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
						echo '<a class="page-num" href = "indexAdmin.php?page=', $counter, '">', $counter, '</a>';
					}
				}
				// Si la page actuelle n'est pas la dernière page
				if ($page_number != $total_pages) {
					// Activer le bouton de page suivante
					echo '<a class="page-num" href = "indexAdmin.php?page=', ($page_number + 1), '">></a>';
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
</div>
</body>
</html>
