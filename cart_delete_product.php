 <?php

 session_start();

 if(isset($_GET['id'])){
 	$id = $_GET['id'];
 	 $key = array_search($id, array_column($_SESSION['cart'], 'id'));

 	 

	unset($_SESSION['cart'][$key]);
	//reset index
	$_SESSION['cart'] = array_values($_SESSION['cart']);

	header('Location:cart.php');
 }
