<?php
include('inc/connect.php');


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$name = '';
	$code = '';
	$price = '';
	$description  = '';
	$image = '';
	$category_id;
	$category_name;

	$query = "SELECT p.id, p.name, p.code, p.price, p.description, p.image, c.name as category_name, c.id as category_id FROM products as p, categories as c WHERE p.category_id = c.id AND p.id = {$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$name = $row['name'];
		$code = $row['code'];		
		$price = $row['price'];
		$description  = $row['description'];		
		$image = $row['image'];
		$category_id = $row['category_id'];
		$category_name = $row['category_name'];	  	
	}else{	
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	//get category list
	$sql = "SELECT * FROM categories";
	$result = $conn->query($sql);

	$categories = array();

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {  	
	    array_push($categories, $row);
	  }
	} 
}

if(isset($_POST['submit'])){

	//senitize incoming data
	$id = $conn->real_escape_string(trim($_POST['id']));
	$name = $conn->real_escape_string(trim($_POST['name']));
	$code = $conn->real_escape_string(trim($_POST['code']));	
	$price = $conn->real_escape_string(trim($_POST['price']));
	$description = $conn->real_escape_string(trim($_POST['description']));
	$category_id = $conn->real_escape_string(trim($_POST['category_id']));


	if($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4){
		$file_name = $_POST['old_file_path'];
		
		
	}else{
		$old_file = $_POST['old_file_path'];	

		$tmp_name = $_FILES["image"]["tmp_name"];
		$file_name = basename(time()."_".$_FILES["image"]["name"]);

		$target_dir = "../uploads";
		unlink("$target_dir/$old_file"); 
		move_uploaded_file($tmp_name, "$target_dir/$file_name");		
	}



	//save to database
	$sql = "UPDATE products set name='{$name}', code='{$code}', price='{$price}', description='{$description}', image='{$file_name}', category_id={$category_id} WHERE id={$id}";

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
                    <h1 class="mt-4">Edit Product</h1>
                    
                    <form action="product_update.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="name">Product Name</label>
					    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">			   
					  </div>
					  <div class="form-group">
					    <label for="code">Product Code</label>
					    <input type="text" class="form-control" name="code" value="<?php echo $code; ?>">			   
					  </div>					  
					  <div class="form-group">
					    <label for="name">Price</label>
					    <input type="number" class="form-control" name="price" value="<?php echo $price; ?>">			   
					  </div>
					  <div class="form-group">
					    <label for="description">Description</label>
					    <textarea class="form-control"  rows="3" name="description"><?php echo $description ?></textarea>		   
					  </div>					  
					  <div class="form-group">
					  	Old Image: 
					  	<?php echo "<p><img src='../uploads/{$image}' width='64'/></p>" ?>
					    <label for="image">New Image</label>
					    <input type="file" class="form-control" name="image">		   
					  </div>
					  <div class="form-group">
					    <label for="category">Category</label>
					    <select class="form-control" name="category_id">
					      <?php foreach($categories as $category):?>
					      	<option value="<?php echo $category['id'];?>" <?php echo ($category_id == $category['id'])?"selected":""; ?>><?php echo $category['name'];?></option>
					      <?php endforeach; ?>			      					
					    </select>
					  </div>
					  
					  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
					  <input type="hidden" name="old_file_path" value="<?php echo $image; ?>"/>

					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
