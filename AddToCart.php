<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$theID = $_POST['theID'];
		$quantity = $_POST['quantityToBuy'];
		
		$cookie_name = "ShoppingCart";
		$cookie_value = "";
		
		// Cookie is stored as comma separated values.
		// If there is already a cookie, add a comma to the end before adding the new stuff to the cart.
		if(isset($_COOKIE[$cookie_name])) {
			$cookie_value = $_COOKIE[$cookie_name] . ",";
		}
		
		$cookie_value = $cookie_value . $theID . "," . $quantity;
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		
		header("Location:search.php?" . $theID . mysqli_error($con));
	}
	else
	{
		?>
		<!DOCTYPE html>
			<html>
			<head>
				<meta name="robots" content="noindex,nofollow" />
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
			
		echo "Band Name: <b>" . $row['BandName'] . "</b><br>";
		echo "Album Name: " . $row['AlbumName'] . "<br>";
		echo "Price: $" . $row['Price'] . "<br>";
		echo "Quantity Available: ". $row['QuantityAvailable'] . "<br>";
		echo "Description: " . $row['Description'] . "<br>";
		echo "Format: " . $row['Format'] . "<br>" ;

		echo 'Quantity to buy: <input type="text" name="quantityToBuy" value="1"><br>';
		echo '<input type="hidden" name="theID" value="' . $theID . '"></input>';
		echo '<input type="submit" value="Add To Cart"></input>';
	}
	
	mysqli_close($con);
?>
		</form>
	</body>
</html>
<?php
}
?>