<?php
include('inc/connect.php');


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$name = '';	

	$query = "SELECT * FROM categories WHERE id={$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$name = $row['name'];		
	}else{	
		header('Location:categories_list.php');
	}
}

if(isset($_POST['submit'])){

	//senitize incoming data
	$id = $conn->real_escape_string(trim($_POST['id']));
	$name = $conn->real_escape_string(trim($_POST['name']));

	//save to database
	$sql = "UPDATE categories set name='{$name}' WHERE id={$id}";

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
                    <h1 class="mt-4">Edit Category</h1>
                    
                      <form action="categories_update.php" method="post">
					  <div class="form-group">
					    <label for="name">Name</label>
					    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">			   
					  </div>					    
					  
					  <input type="hidden" name="id" value="<?php echo $id; ?>"/> 

					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
