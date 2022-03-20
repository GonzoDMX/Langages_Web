
<P>
<B>DEBUTTTTTT DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
<?php
		
// Définir le nombre de secondes pendant lesquelles le script est
// autorisé à s'exécuter, Dans ce cas 500 secondes.
set_time_limit (500);
$path= "docs";

// Envoyer le chemin du répertoire, défini dans la variable $path,
// comme argument à la fonction exploreDir().
explorerDir($path);

function explorerDir($path)
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
		echo "<p>$entree</p>";
		// Vérifier si $entree est une référence au répertoire courant ou au
		// répertoire précédent. Si c'est une telle référence, sautez-la.
		if($entree != "." && $entree != "..")
		{
			// Vérifier si la variable $entree pointe vers un fichier ou un répertoire.
			if(is_dir($path."/".$entree))
			{
				// Stocker temporairement le chemin racine afin qu'il ne soit pas
				// perdu lors de l'opération suivante.
				$sav_path = $path;
				
				// Former un nouveau chemin de répertoire en ajoutant $entree à $path.
				$path .= "/".$entree;
				
				// Appele la fonction explorerDir() de manière récursive
				// avec le nouveau chemin.
				explorerDir($path);
				
				// Restaurer le chemin racine en tant que variable $path.
				$path = $sav_path;
			}
			else
			{
				// Si la variable $entry pointe vers un fichier écriver son chemin
				// complet vers la variable $path_source.
				$path_source = $path."/".$entree;				
				
				//Si c'est un .png ou un .jpeg		
				//Alors je ferais quoi ? Devinez !
				//...
			}
		}
	}
	closedir($folder);
}
?>
<P>
<B>FINNNNNN DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
