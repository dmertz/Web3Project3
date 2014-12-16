<?php
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$theID = $_GET['theID'];
		
		$cookie_name = "ShoppingCart";
		$cookie_value = "";
		$newCookieValue = "";
		
		// Cookie is stored as comma separated values.
		if(isset($_COOKIE[$cookie_name])) {
			$cookie_value = $_COOKIE[$cookie_name];

			$token = strtok($cookie_value, ",");
			while ($token !== false)
			{
				if ($token == $theID)
				{
					// Delete this item from the cart.
					$token = strtok( ",");
				}
				else
				{
					if ($newCookieValue != "")
					{
						$newCookieValue = $newCookieValue . ",";
					}
					$newCookieValue = $newCookieValue . $token;
					
					$token = strtok( ",");
					$newCookieValue = $newCookieValue . "," . $token;
				}
				$token = strtok( ",");
			}
		}

		setcookie($cookie_name, $newCookieValue, time() + (86400 * 30), "/"); // 86400 = 1 day
		
		header("Location:search.php");
	}
?>