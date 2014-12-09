<!DOCTYPE html>
<html>
    <head>
		<meta name="robots" content="noindex,nofollow" />
        <title>Music Store</title>
    </head>
    <body>
	<?php 
	
	echo "<h2>Music Store</h2>";
	
	//Create connection
	$con = mysqli_connect("localhost", "root", "", "project3");
	
	// Check connection
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	
	$sql_select = "SELECT ID, BandName, AlbumName, Format, Description, Price, QuantityAvailable FROM product";
	
	$result = mysqli_query($con, $sql_select);
	
	if(mysqli_errno($con))
		echo mysqli_error($con);
	
	echo "<table>";
	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td><a href='AddToCart.php?theID=" . $row['ID'] . "'><button>Add To Cart</button></a></td>";
		echo "<td><a href='delete.php?theID=" . $row['ID'] . "'><button>Remove From Cart</button></a></td>";
		echo "<td><b>" . $row['BandName'] . "</b> (" . $row['AlbumName'] . ")</td>";
		echo "</tr><tr>";
		echo "<td>$" . $row['Price'] . "</td><td>" . $row['QuantityAvailable'] . " available</td><td>" . $row['Description'] . " (<i>format: " . $row['Format'] . "</i>)" ;
		echo "</td>";
		echo "</tr><tr><td> </td></tr>";
	}
	
	mysqli_close($con);
	?>

    </body>
</html>