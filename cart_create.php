<?php
include('inc/connect.php');
session_start();

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if(isset($_POST['submit'])){
	$product['id'] = $_POST['id'];
	$product['quantity'] = $_POST['quantity'];

	$sql = "SELECT name, price, image FROM products WHERE id={$product['id']}";
    $result = $conn->query($sql) or die($conn->error);;

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $product['name'] = $row['name'];
      $product['price'] = $row['price'];
      $product['image'] = $row['image'];
    }else{
       header('Location:index.php');
    }   



    $key = isInCart($product['id']);
    if($key === false){    	
    	$product['total'] = $product['price'] * $product['quantity'];
    	array_push($_SESSION['cart'], $product);
    }else{
    	$_SESSION['cart'][$key]['quantity'] = $product['quantity'];
    	$_SESSION['cart'][$key]['total'] = $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['price'];
    } 


    header('Location:cart.php');
}


function isInCart($id){
	$key = array_search($id, array_column($_SESSION['cart'], 'id'));
    if($key !== false){
        return $key;
    }else{
        return false;
    }
} 

/*

if(!$_SESSION['cart']){
    $_SESSION['cart'] = array();
}

$key = array_search($pid, array_column($this->products, 'id'));

if(isInCart($pid) == false){            
    $item = array("pid"=>$pid, "qty"=>$qty, "name"=>$this->products[$key]['name'], "price"=>$this->products[$key]['price']);

    $item['total'] = $item['qty']*$item['price'];

    array_push($_SESSION['cart'], $item);
}else{

    $key = array_search($pid, array_column($_SESSION['cart'], 'pid'));

    $_SESSION['cart'][$key]['qty'] =  $qty;
    $_SESSION['cart'][$key]['total']  = $_SESSION['cart'][$key]['qty'] * $_SESSION['cart'][$key]['price'];

    header('Location:cart.php');
}    

function isInCart(){
	$key = array_search($pid, array_column($_SESSION['cart'], 'pid'));
    if($key !== false){
        return true;
    }else{
        return false;
    }
}  

*/