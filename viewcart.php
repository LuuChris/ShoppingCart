<?php session_start();
	if(isset($_POST['checked'])){
		$_SESSION['checked']=$_POST['checked'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home Page</title>
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
			<center><h2>Cart</h2></center>
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
				echo "Your Cart:";
				if(isset($_POST['checked'])){
					foreach($_POST['checked'] as $eq){
						$sql = "SELECT id, seat_number, price, location, user FROM inventory WHERE id=$eq";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								echo "<br>Seat#: " . $row["seat_number"]. " - Location: " . $row["location"]. " - Price: $" . $row["price"];
							}
						} else {
							echo "0 results";
						}
					}
				}
				if(isset($_POST['checked'])){
					foreach($_POST['checked'] as $eg){
						$sql = "SELECT id, parking_space, price, user FROM parking WHERE id=$eg";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								echo "<br>Parking#: " . $row["parking_space"]. " - Price: $" . $row["price"];
							}
						} else {
							echo "0 results";
						}
					}
				}
				$conn->close();
			?>
			<br>
			<div class="creditCardForm">
		<div class="heading">
        <h1>Confirm Purchase</h1>
		</div>
		
		<div class="payment">
			<form>
				<div class="form-group owner">
					<label for="owner">Owner</label>
					<input type="text" class="form-control" id="owner">
				</div>
				<div class="form-group CVV">
					<label for="cvv">CVV</label>
					<input type="text" class="form-control" id="cvv">
				</div>
				<div class="form-group" id="card-number-field">
					<label for="cardNumber">Card Number</label>
					<input type="text" class="form-control" id="cardNumber">
				</div>
				<div class="form-group" id="expiration-date">
					<label>Expiration Date</label>
					<select>
						<option value="01">January</option>
						<option value="02">February </option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select>
						<option value="16"> 2016</option>
						<option value="17"> 2017</option>
						<option value="18"> 2018</option>
						<option value="19"> 2019</option>
						<option value="20"> 2020</option>
						<option value="21"> 2021</option>
					</select>
				</div>
				<div class="form-group" id="credit_cards">
					<img src="assets/images/visa.jpg" id="visa">
					<img src="assets/images/mastercard.jpg" id="mastercard">
					<img src="assets/images/amex.jpg" id="amex">
				</div>
				<div class="form-group" id="pay-now">
					<button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
				</div>
			</form>
		</div>
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="assets/js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="assets/js/script.js"></script>
	<br>
			<form action="viewcart.php" method="post">
				<center>
					<input type="submit" class="button" name="buy">
					<a href="homepage.php" class="button" id="end">Home</a>
				</center>
			</form>
			
			<?php
				$flag = false;
				if(isset($_POST['buy'])){
					update();
				}

				function update(){
					$userid = $_SESSION['ID'];
					$host = "localhost";
					$user = "root";
					$pass = "";
					$db = "db";
					$conn = new mysqli($host, $user, $pass, $db);
					if ($conn -> connect_errno) {
						echo "Failed to connect to MySQL: " . $conn -> connect_error;
						exit();
					}
					if(isset($_SESSION['checked'])){
						foreach($_SESSION['checked'] as $eq){
							$sql = "UPDATE inventory SET user = $userid WHERE id = $eq";
							if($conn->query($sql) === TRUE) {
								$flag=true;
							} else {
								echo "No tickets in cart!<br>";// . $conn->error;
							}
						}
					}
					echo "Your bought tickets:<br>";
					$sql = "SELECT id, seat_number, price, location, user FROM inventory WHERE user = $userid";
					$result = $conn->query($sql);
					
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<br>Seat#: " . $row["seat_number"]. " - Location: " . $row["location"]. " - Price: $" . $row["price"];
						}
					} else {
						echo "0 results";
					}
					
					if($flag){
						echo "<br>You have bought your tickets<br><br>";
					}
					
					if(isset($_SESSION['checked'])){
						foreach($_SESSION['checked'] as $eq){
							$sql = "UPDATE parking SET user = $userid WHERE id = $eq";
							if($conn->query($sql) === TRUE) {
								$flag=true;
							} else {
								echo "No parking selected!<br>";// . $conn->error;
							}
						}
					}
					echo "Your puchased parking!:<br>";
					$sql = "SELECT id, parking_space, price, user FROM parking WHERE user = $userid";
					$result = $conn->query($sql);
					
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<br>Parking#: " . $row["parking_space"]. " - Price: $" . $row["price"];
						}
					} else {
						echo "0 results";
					}
					
					if($flag){
						echo "<br><br>You have purchased your parking";
					}
					$conn->close();
				}
			?>
		</div>
	</body>
</html>
