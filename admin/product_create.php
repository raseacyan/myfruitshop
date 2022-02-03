<?php
include('inc/connect.php');

//get category list
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$categories = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {  	
    array_push($categories, $row);
  }
} 




if(isset($_POST['submit'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));
	$code = $conn->real_escape_string(trim($_POST['code']));	
	$price = $conn->real_escape_string(trim($_POST['price']));
	$description = $conn->real_escape_string(trim($_POST['description']));
	$category_id = $conn->real_escape_string(trim($_POST['category_id']));

	//upload image file
	$target_dir = "../uploads";
	$tmp_name = $_FILES["image"]["tmp_name"];
	$file_name = basename(time()."_".$_FILES["image"]["name"]);	
	move_uploaded_file($tmp_name, "$target_dir/$file_name");

	//save to database
	$sql = "INSERT INTO products (name, code, price, description, image, category_id) VALUES ('{$name}', '{$code}', '{$price}', '{$description}', '{$file_name}', '{$category_id}')";

	if ($conn->query($sql) === TRUE) {
	  header('Location:product_list.php');
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
                    
                    <form action="product_create.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="name">Product Name</label>
					    <input type="text" class="form-control" name="name">			   
					  </div>
					  <div class="form-group">
					    <label for="name">Product Code</label>
					    <input type="text" class="form-control" name="code">			   
					  </div>					  
					  <div class="form-group">
					    <label for="name">Price</label>
					    <input type="number" class="form-control" name="price">			   
					  </div>
					  <div class="form-group">
					    <label for="description">Description</label>
					    <textarea class="form-control"  rows="3" name="description"></textarea>		   
					  </div>					 
					  <div class="form-group">
					    <label for="image">Image</label>
					    <input type="file" class="form-control" name="image">		   
					  </div>

					  <div class="form-group">
					    <label for="category">Category</label>
					    <select class="form-control" name="category_id">
					      <?php foreach($categories as $category):?>
					      	<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
					      <?php endforeach; ?>			      					
					    </select>
					  </div>
					  
					 

					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
