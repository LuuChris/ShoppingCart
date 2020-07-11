<?php session_start();
	echo $_SESSION['ID'] . ", " . $_SESSION['Username'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home Page</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
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
		<br>
		
		<div id="main-wrapper">
			<center><h2>Home Page</h2>
			<h3>Welcome User</h3>
			<img src="imgs/avatar.png" class="avatar"/>
			</center>
			<?php
				$ID = $_SESSION['ID'];
				$host = "localhost";
				$user = "root";
				$pass = "";
				$db = "db";
				$conn = new mysqli($host, $user, $pass, $db);
		
				if ($conn -> connect_errno) {
					echo "Failed to connect to MySQL: " . $conn -> connect_error;
					exit();
				}		
				echo "<br>Your Tickets:";
				$sql = "SELECT id, seat_number, price, location, user FROM inventory WHERE user=$ID";
				$result = $conn->query($sql);
			
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<br>Seat#: " . $row["seat_number"]. " - Location: " . $row["location"]. " - User: " . $row["user"];
					}
				} else {
					echo "0 results";
				}		
				$conn->close();
			?>
			<br/><br/>
			<center>
				<a href="inventory.php" class="button" id="inventory">Inventory</a>
				<a href="viewcart.php" class="button" id="cart">View Cart</a>
				<a href="endlife.php" class="button" id="end">Logout</a>
			</center>
		</div>
	</body>
</html>
