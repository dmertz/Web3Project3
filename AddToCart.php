<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$theID = $_POST['theID'];
		$quantity = $_POST['quantity'];
		
		// Update cookies only.
		
		header("Location:index.php?" . $theID . mysqli_error($con));
	}
	else
	{
		?>
		<!DOCTYPE html>
			<html>
			<head>
				<meta charset="UTF-8">
				<title>Add To Cart</title>
			</head>
			<body>
		<?php
	
		$theID = $_GET['theID'];


		//Create connection
		$con = mysqli_connect("localhost", "root", "", "project3");
		
		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		// WARNING WARNING DO NOT USE THIS LIKE THIS! SQL INJECTION!
		$sql_select = "SELECT ID, BandName, AlbumName, Format, Description, Price, QuantityAvailable FROM product WHERE id = $theID";
		
		$result = mysqli_query($con, $sql_select);
		if(mysqli_errno($con))
			echo mysqli_error($con);
		
		while($row = mysqli_fetch_array($result)) {
			echo '<form method="post" action="';
			echo htmlspecialchars($_SERVER["PHP_SELF"]);
			echo '">';

		echo 'Quantity to buy: <input type="text" name="quantityToBuy" value=' . $row['notes'] . '><br>';
		echo '<input type="hidden" name="theID" value="' . $theID . '"></input>';
		echo '<input type="submit">';
	}
	
	mysqli_close($con);
?>
		</form>
	</body>
</html>
<?php
}
?>