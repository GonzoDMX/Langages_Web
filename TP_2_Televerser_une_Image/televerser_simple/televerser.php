<html>
<div>
<?php
// Définir le répertoire de destination
$dest_dir = "images/";
// Compter le nombre de fichiers déjà à destination
$deja_files = glob($dest_dir . "*");
$file_count = count($deja_files) + 1;
// Obtenir l'extension de fichier du fichier de téléchargement
$file_ext = strtolower(pathinfo(basename($_FILES["myFile"]["name"]), PATHINFO_EXTENSION));
// Construire le chemin pour enregistrer le fichier
$dest_path = $dest_dir . $file_count . "." . $file_ext;

// Vérifier les erreurs
if($_FILES["myFile"]["error"] > 2) {
	echo "Upload failed, there has been an error.";
}
else {
	// Vérifier la taille du fichier
	if ($_FILES["myFile"]["size"] > 8388608) {
	  echo "Upload failed, file size exceeds 8Mb.";
	}
	else{
		// Vérifier le type de fichier
		if($file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "png" ) {
			echo "Upload failed, file must be type 'jpg', 'jpeg' or 'png'.";
		}
		else {
			// Televerser le fichier
			if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $dest_path)) {
				echo "File uploaded successfully !";
		  	} else {
		  		echo "Upload failed, there was an error uploading your file.";
		  	}
		}
	}
}
?>
</div>
<button type="button" value="return" onclick="window.location.href='tele_form.php'">Return</button>
</html>
