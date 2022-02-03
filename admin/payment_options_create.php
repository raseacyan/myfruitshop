<?php
include('inc/connect.php');

if(isset($_POST['submit'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));	
	$description = $conn->real_escape_string(trim($_POST['description']));
	
	//save to database
	$sql = "INSERT INTO payment_options (name, description) VALUES ('{$name}', '{$description}')";

	if ($conn->query($sql) === TRUE) {
	  header('Location:payment_options_list.php');
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Add Payment Option</h1>
                    
                    <form action="payment_options_create.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" class="form-control" name="name">			   
					  </div>
					  <div class="form-group">
					    <label for="name">Description</label>
					    <textarea class="form-control"  rows="3" name="description"></textarea>			   
					  </div>				  			  
					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
