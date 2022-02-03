<?php
include('inc/connect.php');

if(isset($_POST['submit'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));	

	//save to database
	$sql = "INSERT INTO categories (name) VALUES ('{$name}')";

	if ($conn->query($sql) === TRUE) {
	  header('Location:categories_list.php');
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
$conn->close();
?>

<?php include("inc/header.php"); ?>
<main>
	<div class="container-fluid px-4">
		<h1 class="mt-4">Add Category</h1>          
		<form action="categories_create.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" name="name">			   
			</div>		  			  
			<input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
		</form>
	</div>
</main>
<?php include("inc/footer.php"); ?>
