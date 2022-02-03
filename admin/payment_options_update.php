<?php
include('inc/connect.php');


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$name = '';
	$description  = '';
	

	$query = "SELECT * FROM payment_options WHERE id={$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$name = $row['name'];	
		$description  = $row['description'];				
	}else{	
		header('Location:shipping_rates_list.php');
	}
}

if(isset($_POST['submit'])){



	//senitize incoming data
	$id = $conn->real_escape_string(trim($_POST['id']));
	$name = $conn->real_escape_string(trim($_POST['name']));	
	$description = $conn->real_escape_string(trim($_POST['description']));


	//save to database
	$sql = "UPDATE payment_options set name='{$name}', description='{$description}' WHERE id={$id}";

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
                    <h1 class="mt-4">Edit Payment Option</h1>
                    
                    <form action="payment_options_update.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">			   
					  </div>
					  <div class="form-group">
					    <label for="name">Description</label>
					    <textarea class="form-control"  rows="3" name="description"><?php echo nl2br($description); ?></textarea>			   
					  </div>
					  <input type="hidden" name="id" value="<?php echo $id; ?>"/> 				  			  
					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                     
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
