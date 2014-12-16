<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$theID = $_POST['theID'];
		$quantity = $_POST['quantityToBuy'];
		
		$cookie_name = "ShoppingCart";
		$cookie_value = "";
		$newCookieValue = "";
		$wasUpdated = false;
		
		// Cookie is stored as comma separated values.
		if(isset($_COOKIE[$cookie_name])) {
			$cookie_value = $_COOKIE[$cookie_name];

			// Check if this item is already in the cart.
			$token = strtok($cookie_value, ",");

			while ($token !== false)
			{
				if ($newCookieValue != "")
				{
					$newCookieValue = $newCookieValue . ",";
				}
				$newCookieValue = $newCookieValue . $token;
				
				if ($token == $theID)
				{
					$token = strtok( ",");
					// Update the amount
					$wasUpdated = true;
					$newCookieValue = $newCookieValue . "," . $quantity;
				}
				else
				{
					$token = strtok( ",");
					$newCookieValue = $newCookieValue . "," . $token;
				}
				$token = strtok( ",");
			}
		}
		if (!$wasUpdated)
		{
			if ($newCookieValue != "")
			{
				$newCookieValue = $newCookieValue . ",";
			}
			$newCookieValue = $newCookieValue . $theID . "," . $quantity;
		}
		setcookie($cookie_name, $newCookieValue, time() + (86400 * 30), "/"); // 86400 = 1 day
		
		header("Location:search.php?theID=" . $theID);
	}
	else
	{
		?>
		<!DOCTYPE html>
			<html>
			<head>
				<meta name="robots" content="noindex,nofollow" />
				<meta charset="UTF-8">
				<title>View Cart</title>
				<link rel="stylesheet" type="text/css" href="style.css">
			</head>
			<body>
		<?php
		
		$ids[0] = 0;
		$amounts[0] = 0;
		$x = 0;
		$idList = "";
		
		$subtotal = 0;
		
		$cookie_name = "ShoppingCart";
		$cookie_value = "";
		
		// Cookie is stored as comma separated values.
		if(isset($_COOKIE[$cookie_name])) 
		{
			$cookie_value = $_COOKIE[$cookie_name];
			
			$token = strtok($cookie_value, ",");
			while ($token !== false)
			{
				$ids[$x] = $token;
				if ($idList != "")
				{
					$idList = $idList . ",";
				}
				$idList = $idList . $token;;
				$token = strtok( ",");	
				$amounts[$x] = $token;
				$token = strtok( ",");
				$x++;
			}
		}

		//Create connection
		$con = mysqli_connect("localhost", "root", "", "project3");
		
		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		if ($idList == "")
		{
			echo "There are no items in your shopping cart.<br>";
		}
		else
		{
			$idList = mysqli_real_escape_string($con, $idList);
			$sql_select = "SELECT ID, BandName, AlbumName, Format, Description, Price, QuantityAvailable FROM product WHERE id IN ($idList)";
			
			$result = mysqli_query($con, $sql_select);
			if(mysqli_errno($con))
				echo mysqli_error($con);
			
			while($row = mysqli_fetch_array($result))
			{	
				$amount = 0;
				for ($i = 0; $i < $x; $i++)
				{
					if ($ids[$i] == $row['ID'])
					{
						// Match
						$amount = $amounts[$i];
						break;
					}
				}
				
				$itemSubtotal = $amount * $row['Price'];
				$subtotal = $subtotal + $itemSubtotal;
				
				echo "Band Name: <b>" . $row['BandName'] . "</b><br>";
				echo "Album Name: " . $row['AlbumName'] . "<br>";
				echo "Price: $" . $row['Price'] . "<br>";
				echo "Quantity Available: ". $row['QuantityAvailable'] . "<br>";
				echo "Description: " . $row['Description'] . "<br>";
				echo "Format: " . $row['Format'] . "<br>" ;

				echo "Quantity to buy: " . $amount . "<br>";
				echo 'Item Subtotal: $' . $itemSubtotal;
				echo "<br><br>";
			}
			
			echo "Subtotal: $" . $subtotal . "<br>";
		
			mysqli_close($con);
	}
?>
		</form>
		<br>
		<a href='search.php'><button>Return to Search</button></a>
	</body>
</html>
<?php
}
?>