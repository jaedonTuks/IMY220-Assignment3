<?php
//jaedon heger
	// See all errors and warnings
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	// Your database details might be different
	$mysqli = mysqli_connect("localhost", "root", "", "dbUser");

	$email = isset($_POST["email"]) ? $_POST["email"] : false;
	$pass = isset($_POST["pass"]) ? $_POST["pass"] : false;

?>

<!DOCTYPE html>
<html>
<head>
	<title>IMY 220 - Assignment 3</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Jaedon Heger">
	<!-- Replace Name Surname with your name and surname -->
</head>
<body>
	<div class="container">
		<?php


			if($email && $pass){

				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res)){
					echo 	"<table class='table table-bordered mt-3'>
								<tr>
									<td>Name</td>
									<td>" . $row['name'] . "</td>
								<tr>
								<tr>
									<td>Surname</td>
									<td>" . $row['surname'] . "</td>
								<tr>
								<tr>
									<td>Email Address</td>
									<td>" . $row['email'] . "</td>
								<tr>
								<tr>
									<td>Birthday</td>
									<td>" . $row['birthday'] . "</td>
								<tr>
							</table>";

					echo 	"<form enctype='multipart/form-data' action='login.php' method='post'>
								<div class='form-group'>
									<input type='hidden' id='email' name='email' value='$email'>
									<input type='hidden' id='pass' name='pass' value='$pass'>
									<input type='file' class='form-control' name='picToUpload' id='picToUpload' /><br/>

									<input type='hidden' id='imageUp' name='imageUp' value='yes'>
									<input type='submit' class='btn btn-standard' value='Upload Image' name='submit' />
								</div>
						  	</form>";

						if(	isset($_POST["imageUp"])){
								//	echo "Hurr";
									$dir="gallery/";

									$upload= $_FILES["picToUpload"];
									if(( $upload["type"] == "image/jpeg" ||  $upload["type"] == "image/jpg") && $upload["size"] < 1000000){


											move_uploaded_file($upload["tmp_name"],$dir . $upload["name"]);
											//echo $dir;
											$id=$row["user_id"];
											$targFile=$upload["name"];
										//	echo $targFile;
											$query = "INSERT INTO tbgallery (user_id,filename) VALUES ($id,'$targFile');";
											$res = $mysqli->query($query);
									//	echo "corect";
									}


								//			while ($row1 = $result1->fetch_assoc()) {
				//	    $order_description = $row1['order_description'];
				//	    echo $order_description."\n";
				//	}


								}
								$id=$row["user_id"];
								$query="SELECT * FROM tbgallery WHERE user_id ='$id'";

								$result = $mysqli->query($query);
								if($result){
									echo	"	<h1>Image gallery</h1>
											<div class='imageGallery row'>";
										while($row = mysqli_fetch_array($result)){
											$picName=$row["filename"];
											echo"<div class='col-3' style='background-image: url(gallery/$picName)'></div>";
										//	echo
										}
									echo "</div>";
								}
				}
				else{
					echo 	'<div class="alert alert-danger mt-3" role="alert">
	  							You are not registered on this site!
	  						</div>';
				}
			}
			else{

					echo 	'<div class="alert alert-danger mt-3" role="alert">
		  						Could not log you in!
		  					</div>';

			}
		 $mysqli->close();
		?>
	</div>
</body>
</html>
