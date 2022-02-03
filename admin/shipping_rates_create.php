<?php
include('inc/connect.php');

if(isset($_POST['submit'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));	
	$description = $conn->real_escape_string(trim($_POST['description']));
    $price = $conn->real_escape_string(trim($_POST['price']));


	
	//save to database
	$sql = "INSERT INTO shippings (name, description, price) VALUES ('{$name}', '{$description}','{$price}')";

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
                    <h1 class="mt-4">Add Product</h1>
                    
                    <form action="shipping_rates_create.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" class="form-control" name="name">			   
					  </div>
					  <div class="form-group">
					    <label for="name">Description</label>
					    <textarea class="form-control"  rows="3" name="description"></textarea>			   
					  </div>					  
					  <div class="form-group">
					    <label for="name">Price</label>
					    <input type="number" class="form-control" name="price">			   
					  </div>			  
					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
