<?php
include('inc/connect.php');
session_start();
unset($_SESSION['success']);

if(isset($_POST['submit'])){

	//senitize incoming data
	$email = $conn->real_escape_string(trim($_POST['email']));
	$password = $conn->real_escape_string(trim($_POST['password']));
	$password = md5($password);

	$sql = "SELECT * FROM users WHERE email = '{$email}' AND password='{$password}'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  $row = $result->fetch_assoc();
	  $_SESSION['success'] = 'Login successful';
	  $_SESSION['user_id'] = $row['id'];
	  $_SESSION['user_name'] = $row['name'];

	  header('Location:index.php');
	  
	} else {
	  	return array('status'=>0,'data'=>array());
	}
		
}

$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">      	
                  

                    <div class="row">
                		<div class="col-8 offset-2 mb-4" >
                			<h1 class="mt-4">Login</h1>

                			<?php if(isset($_SESSION['success'])): ?>
                			<div class="alert alert-success" role="alert">
	  								<?php 
	  									echo $_SESSION['success'];
	  									unset($_SESSION['success']);
	  								?>
							</div>
                			<?php endif; ?>
                			<form action="login.php" method="post" enctype="multipart/form-data">
							  <div class="form-group">
							    <label for="email">Email</label>
							    <input type="text" class="form-control" name="email">	
							  </div>

							  <div class="form-group">
							    <label for="password">Password</label>
							    <input type="password" class="form-control" name="password">	
							  </div>	 
							

							  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
							  
							</form> 
                		

                		</div>
                	</div>
                    
                                       
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
