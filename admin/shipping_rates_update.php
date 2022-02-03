<?php
include('inc/connect.php');


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$name = '';
	$description  = '';
    $price = '';	

	$query = "SELECT * FROM shippings WHERE id={$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$name = $row['name'];	
		$description  = $row['description'];
		$price = $row['price'];		
	}else{	
		header('Location:shipping_rates_list.php');
	}
}

if(isset($_POST['submit'])){

	//senitize incoming data
	$id = $conn->real_escape_string(trim($_POST['id']));
	$name = $conn->real_escape_string(trim($_POST['name']));	
	$description = $conn->real_escape_string(trim($_POST['description']));
	$price = $conn->real_escape_string(trim($_POST['price']));

	//save to database
	$sql = "UPDATE shippings set name='{$name}', description='{$description}', price='{$price}' WHERE id={$id}";

	if ($conn->query($sql) === TRUE) {
	  header('Location:shipping_rates_list.php');
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Shipping Rate</h1>
                    
                      <form action="shipping_rates_update.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">			   
					  </div>
					  <div class="form-group">
					    <label for="name">Description</label>
					    <textarea class="form-control"  rows="3" name="description"><?php echo $description; ?></textarea>			   
					  </div>					  
					  <div class="form-group">
					    <label for="name">Price</label>
					    <input type="number" class="form-control" name="price" value="<?php echo $price; ?>">			   
					  </div>		  
					  
					  <input type="hidden" name="id" value="<?php echo $id; ?>"/> 

					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
