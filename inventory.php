<?php session_start();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inventory</title>
		<link rel="stylesheet" href="styles.css">
		<style>
			.button {
				background-color: teal;
				border: none;
				color: white;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				margin: 4px 2px;
				cursor: pointer;
			}
		</style>
	</head>

	<body style = "background-color:#7f8c8d">
		<div id="main-wrapper">
			<center><h2>Inventory</h2></center>
			
			<form action="parking.php" method="post">
			<?php
				$host = "localhost";
				$user = "root";
				$pass = "";
				$db = "db";
				$conn = new mysqli($host, $user, $pass, $db);
		
				if ($conn -> connect_errno) {
					echo "Failed to connect to MySQL: " . $conn -> connect_error;
					exit();
				}
		
				echo "Connected successfully";
				$sql = "SELECT id, seat_number, price, location, user FROM inventory WHERE user IS NULL";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<br><input type='checkbox' name='checked[]' value='" . $row["id"] . "'";
						echo "<br>Seat#: " . $row["seat_number"]. " - Location: " . $row["location"]. " - Price: $" . $row["price"];
					}
				} else {
					echo "0 results";
				}
			$conn->close();
			?>
			<br>
			<center>
				<input type="submit" class="button" name="inven">
				<a href="homepage.php" class="button" id="end">Home</a>
			</center>
			<form>
		</div>
	</body>
</html>
