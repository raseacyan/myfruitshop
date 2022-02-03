<?php
include('inc/connect.php');
session_start();
unset($_SESSION['success']);

if(isset($_POST['submit'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));
	$email = $conn->real_escape_string(trim($_POST['email']));
	$password = $conn->real_escape_string(trim($_POST['password']));
	$password = md5($password);

	$sql = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$password}')";

	if ($conn->query($sql) === TRUE) {
	  $_SESSION['success'] = 'Registration successful';
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
		
}

$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">      	
                  

                    <div class="row">
                		<div class="col-8 offset-2 mb-4" >
                			<h1 class="mt-4">Register</h1>

                			<?php if(isset($_SESSION['success'])): ?>
                			<div class="alert alert-success" role="alert">
	  								<?php 
	  								echo $_SESSION['success'];
	  								unset($_SESSION['success']);
	  								?>
							</div>
                			<?php endif; ?>
                			<form action="register.php" method="post" enctype="multipart/form-data">
                			  <div class="form-group">
							    <label for="name">Name</label>
							    <input type="text" class="form-control" name="name" required>	
							  </div>

							  <div class="form-group">
							    <label for="email">Email</label>
							    <input type="text" class="form-control" name="email" required>	
							  </div>

							  <div class="form-group">
							    <label for="password">Password</label>
							    <input type="password" class="form-control" name="password" required>	
							  </div>	 
							

							  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
							  
							</form> 
                		

                		</div>
                	</div>
                    
                                       
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
