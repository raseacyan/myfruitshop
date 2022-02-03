<?php
include('inc/connect.php');

if(isset($_GET['id'])){
	
	$id = $_GET['id'];

	$query = "SELECT * FROM products WHERE id={$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){	
		$row = $result->fetch_assoc();	
		$image = $row['image'];	  	
	}else{	
		header('Location:product_list.php');
	}

	

	$query = "DELETE FROM products WHERE id={$id}";

	$result = $conn->query($query);

	if ($result) {
	  //delete image
	  $target_dir = "../uploads";
	  unlink("$target_dir/$image"); 

	  header("Location: product_list.php");	
	} else {
	  echo "Error deleting record: " . $conn->error;
	}



}else{
	header("Location: product_list.php");
}

$conn->close();
?>