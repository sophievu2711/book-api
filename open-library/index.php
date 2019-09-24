<form action="index.php" method="get">
<label>Enter ISBN:</label><br />
<input type="text" name="isbn" placeholder="Enter ISNB" required/>
<br /><br />
<input type="submit" name="submit">
</form>


<?php	
	require_once ('openlib.php');

	if (!empty($_GET['isbn'])) {
		$query = new OpenLibrary;
		$query->setIsbn($_GET['isbn']);		
		
		$key = $query->getKey();
		$result = $query->curl($_GET['isbn']);
		
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		 
		if(!$result){
			echo "Invalid ISBN";
		}else{ 
			echo "<table border='1'>";
			echo $query->getAuthors();
			echo $query->getCover();
			echo $query->getTitle();
			echo $query->getIsbn10();
			echo $query->getIsbn13();		

		echo "</table>";
		}
	}
?>


<?php
	
	
?>