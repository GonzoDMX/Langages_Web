<!-- TP 1 PAGINATION - ANDREW OSHEI -->
<!-- Langages Web - Master 1 Informatique-->
<html>
<!-- Définir des styles pour les éléments html utilisés dans la page -->
<style>
	a {
		font-size: 32;
		margin-left: 5px;
		margin-right: 5px;
	}
	td {
		border: 1px solid #333;
		padding: 5px;
	}
	th {
		padding: 5px;
	}
	thead,
	tfoot {
		background-color: #333;
		color: #fff;
	}
	h2 {
		text-align: center;
		width: 50%;
	}
	.table-div {
		text-align: center;
		width:50%;
		margin: 10px;
	}
</style>
<body>
	<!-- Démarrer le code PHP -->
	<?php
		// Connecter à MySQL
		// 'localhost' en tant qu'utilisateur 'andrew' avec le mot de passe ...
		$conn = mysqli_connect('localhost', 'andrew', 'lets give it another go');

		// Si la connexion à MySQL échoue
		if (! $conn) {
			// afficher le message d'échec
			die("La connexion à la base de données a échoué" . mysqli_connect_error());
		}
		// Si la connexion à MySQL est réussie
		else {
		         // Sélectionner la base de données avec les données de notre page
		         mysqli_select_db($conn, 'pagination_mock');
		}

		// Définir la limite du nombre de lignes affichées par page
		$row_limit = 10;

		// Créer une requête pour récupérer toutes les lignes de la table 'page_mock'
		$get_data = "SELECT * FROM page_mock";

		// Envoyer la requête à la base de données et récupérer les données
		$result = mysqli_query($conn, $get_data);
		
		// Obtenir le nombre de lignes reçues
		$total_rows = mysqli_num_rows($result);

		// Calculer le nombre de pages nécessaires pour afficher les données
		$total_pages = ceil ($total_rows / $row_limit);

		// Si la variable 'page' n'est pas définie par Http
		if (!isset ($_GET['page']) ) {
			// selectionner la première page
			$page_number = 1;
		// Si la variable 'page' est définie par Http
		} else {
			// Définisser la page actuelle sur le numéro reçu
		    $page_number = $_GET['page'];
		}    

		// Calculer le décalage de ligne pour la page actuelle
		$page_offset = ($page_number-1) * $row_limit;   

		// Créer une requête pour obtenir des données pour la page actuelle
		$get_data = "SELECT * FROM page_mock LIMIT " . $page_offset . ',' . $row_limit;
		
		// Envoyer la requête et recevoir les données
		$result = mysqli_query($conn, $get_data);

		// Afficher le titre de la page
		echo '<h2>Base de données de livres</h2>';

		// Créer un tableau html pour afficher les données
		echo '<div class="table-div">';
		echo '<table style="width: 100%;"><thead><tr>';
		
		// Définir les en-têtes du tableau
		echo '<th colspan="4">Page ' . $page_number . '</th>';
		echo '</tr><tr>';
		
		// Définir les étiquettes des colonnes du tableau
		echo '<th colspan="1">Idx</th>';
		echo '<th colspan="1">Code</th>';
		echo '<th colspan="1">Titre</th>';
		echo '<th colspan="1">Auteur</th>';
		echo '</tr></thead><tbody>';
		
		// Incrémenter 'offset' pour afficher l'index de ligne
		$page_offset = $page_offset + 1;
		
		// Pour toutes les lignes reçues de la base de données
		while ($row = mysqli_fetch_array($result)) {
			// Ajouter une ligne de données au tableau
			echo '<tr>';
		    echo '<td>' . $page_offset . '</td>';
		    echo '<td>' . $row['cote'] . '</td>';
		    echo '<td>' . $row['titre'] . '</td>';
		    echo '<td>' . $row['auteur'] . '</td>';
		    echo '</tr>';
		    
		    // Incrémenter 'offset' pour les indices de ligne
		    $page_offset = $page_offset + 1;
		}
		
		// Fermer le tableau
		echo '</tbody></table></div>';

		// Élément div de début pour la pagination
		echo '<div style="text-align: center; width:50%;">';

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
		    echo '<a href = "index.php?page=' . $counter . '">' . $counter . ' </a>';
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
		// Fermer l'élément div de pagination
		echo '</div>';
	?>
	</div>
</body>
</html>
