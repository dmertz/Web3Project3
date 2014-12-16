<!DOCTYPE html>
<html>
    <head>
		<meta name="robots" content="noindex,nofollow" />
        <title>Music Store</title>
		<link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
	<?php 
	
	echo "<h2>Music Store</h2>";
	
	// Search box
	echo "<br>";
	echo "Search for band:";
	echo "<br>";
	echo "<form>";
	echo "<input name='bandName'></input>";
	echo "<input type='submit' value='Search'></input>";
	echo "</form>";
	echo "<br>";
	
	//Create connection
	$con = mysqli_connect("localhost", "root", "", "project3");
	
	// Check connection
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		
	if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['bandName'])) {
		$bandName = $_GET['bandName'];
		$bandName = mysqli_real_escape_string($con, $bandName);
		$sql_select = "SELECT ID, BandName, AlbumName, Format, Description, Price, QuantityAvailable FROM product WHERE bandName like '%$bandName%'";
		
		$result = mysqli_query($con, $sql_select);
		
		if(mysqli_errno($con))
			echo mysqli_error($con);
		
		echo "<table>";
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td><a href='AddToCart.php?theID=" . $row['ID'] . "'><button>Add To Cart</button></a></td>";
			echo "<td><a href='DeleteFromCart.php?theID=" . $row['ID'] . "'><button>Remove From Cart</button></a></td>";
			echo "<td><b>" . $row['BandName'] . "</b> (" . $row['AlbumName'] . ")</td>";
			echo "</tr><tr>";
			echo "<td>$" . $row['Price'] . "</td><td>" . $row['QuantityAvailable'] . " available</td><td>" . $row['Description'] . " (<i>format: " . $row['Format'] . "</i>)" ;
			echo "</td>";
			echo "</tr><tr><td> </td></tr>";
		}
		
		mysqli_close($con);
		
		?>
		</table>
		<br>
		<a href="CheckOut.php"><button>Check Out</button></a>
		<?php
		}
	else
	{
		$sql_select = "SELECT ID, BandName, AlbumName, Format, Description, Price, QuantityAvailable FROM product";
	}
?>
    </body>
</html>