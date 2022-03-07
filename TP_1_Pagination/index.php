<html>  
<head>  
	<title> Pagination in PHP </title>  
</head>  
<style>
a {
	font-size: 32;
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
</style>
<body>
	<?php
		// MySQL host, username, pword
		$conn = mysqli_connect('localhost', 'andrew', 'lets give it another go');  

		if (! $conn) {  
		         die("Connection failed" . mysqli_connect_error());  
		}  
		else {  
		         // connect to the database named Pagination
		         mysqli_select_db($conn, 'pagination_mock');  
		}  

		// variable to store number of rows per page
		$limit = 10; 

		// query to retrieve all rows from the table Countries
		$getQuery = "SELECT * FROM page_mock";    

		// get the result
		$result = mysqli_query($conn, $getQuery);  
		$total_rows = mysqli_num_rows($result);    

		// get the required number of pages
		$total_pages = ceil ($total_rows / $limit);    

		// update the active page number
		if (!isset ($_GET['page']) ) {  
		    $page_number = 1;  
		} else {  
		    $page_number = $_GET['page'];  
		}    

		// get the initial page number
		$initial_page = ($page_number-1) * $limit;   

		// get data of selected rows per page    
		$getQuery = "SELECT * FROM page_mock LIMIT " . $initial_page . ',' . $limit;  
		$result = mysqli_query($conn, $getQuery);       


		$counter = (($page_number - 1) * 10) + 1;
		$current = $page_number;

		echo '<h2 style="text-align: center; width: 50%;">Base de données de livres</h2>';

		echo '<div style="text-align: center; width:50%; margin: 10px;">';
		echo '<table style="width: 100%;"><thead><tr>';
		echo '<th colspan="4">Page ' . $current . '</th>';
		echo '</tr><tr>';
		echo '<th colspan="1">Idx</th>';
		echo '<th colspan="1">Code</th>';
		echo '<th colspan="1">Titre</th>';
		echo '<th colspan="1">Auteur</th>';
		echo '</tr></thead><tbody>';
		//display the retrieved result on the webpage  
		while ($row = mysqli_fetch_array($result)) {
			echo '<tr>';
		    echo '<td>' . $counter . '</td>';
		    echo '<td>' . $row['cote'] . '</td>';
		    echo '<td>' . $row['titre'] . '</td>';
		    echo '<td>' . $row['auteur'] . '</td>';
		    echo '</tr>';
		    $counter = $counter + 1;
		}
		echo '</tbody></table></div>';

		echo '<div style="text-align: center; width:50%;">';
		
		// If current page greater than 1 add back button
		if ($current > 1) {
			echo '<a style="margin-left: 5px; margin-right: 5px;" href = "index.php?page=' . ($current - 1) . '"><</a>';
		}
		else {
			echo '<a style="margin-left: 5px; margin-right: 5px;"><</a>';
		}
		
		for($page_number = 1; $page_number<= $total_pages; $page_number++) {  
		    echo '<a href = "index.php?page=' . $page_number . '">' . $page_number . ' </a>';  
		}
		
		// If current page is not last page add forward button
		if ($current != $total_pages) {
			echo '<a style="margin-left: 5px; margin-right: 5px;" href = "index.php?page=' . ($current + 1) . '">></a>';
		}
		else {
			echo '<a style="margin-left: 5px; margin-right: 5px;">></a>';
		}
		echo '</div>';
	?>
	</div>

</body>  
</html> 
