<?php
include("inc/connect.php");
session_start();

$cart = array();
if(isset($_SESSION['cart'])){
    $cart_subtotal = 0;
    foreach($_SESSION['cart'] as $product){
        $cart_subtotal += $product['total'];
    }
    $_SESSION['order']['subtotal'] = $cart_subtotal;

    $cart = $_SESSION['cart'];
}

//shipping data
$sql = "SELECT * FROM shippings";
$result = $conn->query($sql);

$shipping_rates = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {    
    array_push($shipping_rates, $row);
  }
} 
        


?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Cart</h1>
                    <a class="btn btn-primary mb-4" href="index.php">Shop more</a>
                    <a class="btn btn-primary mb-4" href="cart_delete.php">Empty Cart</a>
                    <?php if(count($cart)): ?>
                    	

                    	<div class="card mt-4">           		                          
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>                                   
                                    <tbody>
                                    	<?php foreach($cart as $product): ?> 
                                    	<tr>
                                    		<td><img src="<?php echo "uploads/".$product['image']; ?>" width="50"/></td>
                                    		<td><?php echo $product['name']; ?></td>
                                    		<td><?php echo $product['quantity']; ?></td>
                                    		<td><?php echo $product['price']; ?></td>
                                    		<td><?php echo $product['total']; ?></td>
                                            <td>
                                                <a href="product.php?id=<?php echo $product['id'] ?>">Update</a> | 
                                                <a href="cart_delete_product.php?id=<?php echo $product['id'] ?>">Delete</a>
                                            </td>
                                    	</tr>                                    	
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <p>Cart Total: <?php echo $_SESSION['order']['subtotal']; ?></p>
                                
                            </div>
                        </div>
                        <a class="btn btn-primary mb-4 mt-4" href="order_create.php">Check Out</a>
                        
                    <?php else:?>
                    	<p>No products in Cart</p>
                    <?php endif; ?>
                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
