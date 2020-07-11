
<!DOCTYPE html>
<html>
	<head>
		<title>Registration Page</title>
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
			$flag=false;
		
			if(isset($_POST['register'])) {
				$U = isset($_POST['user']) ? $_POST['user'] : '';
				$P = isset($_POST['pass']) ? $_POST['pass'] : '';
				$sql = "SELECT id, username, password FROM user WHERE username='$U'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<br> id: ". $row["id"]. " - Name: ". $row["username"]. "<br>";
					$msg="<span style='color:white'>Username Taken!</span>";
					}
				} else {
					$sql = "INSERT INTO user (id, username, password) VALUES (NULL, '$U', '$P')";
				
					if($conn->query($sql)=== TRUE){
						session_start();
						$_SESSION['Username']=$row["username"];
						$_SESSION['ID']=$row["id"];
						$flag=true;
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				}
			}		
			if($flag){
				header("location:homepage.php");
				exit;
			}
			$conn->close();
		?>

		<div id="main-wrapper">
			<center><h2>Registration</h2></center>
			<center><img src="imgs/avatar.png" class="avatar"/></center>
			<?php
				if(isset($msg)){
				echo $msg;
				}
			?>
			<form class="myform" action="register.php" method="post">
				<center>
				<label>Username:</label>
				<input type="text" name="user" class="textbox" required placeholder="Username" maxlength="10" autofocus required/>
				<br>
				<label>Password:</label>
				<input type="password" name="pass" class="textbox" required placeholder="Password" maxlength="10" required/>
				<br>
					<button type="submit" class="button" name="register">Register!</button>
					<button type="button" class="button" onclick="location.href='index.php';">Back</button>
				</center>
			</form>
		</div>
	</body>
</html>
