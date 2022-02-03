<?php
include('inc/connect.php');

if(isset($_GET['id'])){
	
	$id = $_GET['id'];	

	$query = "DELETE FROM categories WHERE id={$id}";

	$result = $conn->query($query);

	if ($result) {
	  header("Location: categories_list.php");	
	} else {
	  echo "Error deleting record: " . $conn->error;
	}

}else{
	header("Location: categories_list.php");
}

$conn->close();
?>