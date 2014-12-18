<!DOCTYPE html>
	<html>
	<head>
		<meta name="robots" content="noindex,nofollow" />
		<meta charset="UTF-8">
		<title>View Cart</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<h2>Music Store</h2>
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
				if (is_numeric($token))
					$idList = $idList . $token;
					
				$token = strtok( ",");	
				if (is_numeric($token))
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

				echo "Quantity to buy: " . $amount . " <a href='AddToCart.php?theID=" . $row['ID'] . "&quantityToBuy=" . $amount . "'><button>Change Amount</button></a>";
				echo "<a href='DeleteFromCart.php?theID=" . $row['ID'] . "'><button>Remove From Cart</button></a><br>";
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
		<a href="CheckOut.php"><button>Check Out</button></a>
	</body>
</html>