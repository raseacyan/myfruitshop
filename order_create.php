<?php
include('inc/connect.php');
session_start();

if(!isset($_SESSION['user_id'])){
	header('Location:login.php');
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){  

	$cart = array();
	if(isset($_SESSION['cart'])){
		$cart_subtotal = 0;
    foreach($_SESSION['cart'] as $product){
        $cart_subtotal += $product['total'];
    }
    $_SESSION['order']['subtotal'] = $cart_subtotal;
	    $cart = $_SESSION['cart'];
	}


    $sql = "SELECT * FROM shippings";
    $result = $conn->query($sql);

    $shipping_rates = array();

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {    
        array_push($shipping_rates, $row);
      }
    } 


    $sql = "SELECT * FROM payment_options";
    $result = $conn->query($sql);

    $payment_options = array();

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {    
        array_push($payment_options, $row);
      }
    }

    $shipping_rate_id = isset($_SESSION['order']['shipping_rate_id'])?$_SESSION['order']['shipping_rate_id']:'';
    $payment_method = isset($_SESSION['order']['payment_method'])?$_SESSION['order']['payment_method']:'';
    $customer_name = isset($_SESSION['order']['customer_name'])?$_SESSION['order']['customer_name']:'';
    $customer_phone = isset($_SESSION['order']['customer_phone'])?$_SESSION['order']['customer_phone']:'';
    $customer_address = isset($_SESSION['order']['customer_address'])?$_SESSION['order']['customer_address']:'';
    $customer_message = isset($_SESSION['order']['customer_message'])?$_SESSION['order']['customer_message']:'';
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){

	//senitize incoming data

	$shipping_rate_id = $conn->real_escape_string(trim($_POST['shipping_rate_id']));
	$payment_method = $conn->real_escape_string(trim($_POST['payment_method']));
	$customer_name =  $conn->real_escape_string(trim($_POST['customer_name']));
	$customer_phone =  $conn->real_escape_string(trim($_POST['customer_phone']));
	$customer_address =  $conn->real_escape_string(trim($_POST['customer_address']));
	$customer_message =  $conn->real_escape_string(trim($_POST['customer_message']));


	$_SESSION['order']['shipping_rate_id'] = $shipping_rate_id;
	$_SESSION['order']['payment_method'] = $payment_method;	
	$_SESSION['order']['customer_name'] = $customer_name;
	$_SESSION['order']['customer_phone'] = $customer_phone;
	$_SESSION['order']['customer_address'] = $customer_address;
	$_SESSION['order']['customer_message'] = $customer_message;	
	$_SESSION['order']['payment_method'] = $payment_method;	

	header('Location:order_confirm.php');
	
}

$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">

                	   	
                  

                    <div class="row">
                		<div class="col-8 offset-2 mb-4" >
                			<h1 class="display-5 fw-bolder mt-4">Your Cart</h1>
                        
                        <table class="table">
                        	<tr>
                                <th>Image</th>
                        		<th>Product Name</th>
                        		<th>Quantity</th>
                        		<th>Price</th>
                        		<th>Total</th>
                        	</tr>	
                        	<?php foreach($cart as $item): ?>
                                <tr>
                                    <td><img src="uploads/<?php echo $item['image']; ?>" width="50"></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['price']; ?></td>
                                    <td><?php echo $item['total']; ?></td>
                                </tr>
                            <?php endforeach; ?>                       	
                        </table>
                        <p>Cart Total: <?php echo $_SESSION['order']['subtotal']; ?></p>
                			<h1 class="mt-4">Create Order</h1>
                			
                			<form action="order_create.php" method="post" enctype="multipart/form-data">
							  

							  
							  <div class="form-group">
							  	   <label>Shipping Option</label>
							  	   <?php foreach($shipping_rates as $shipping_rate): ?>
							  	   <?php 
							  	   	 $checked = ($shipping_rate_id == $shipping_rate['id'])?'checked':'';
							  	   ?>
								  <div class="form-check">							  	  
									  <input class="form-check-input" type="radio" name="shipping_rate_id"  value="<?php echo $shipping_rate['id']; ?>" <?php echo $checked; ?>>
									  <label class="form-check-label" for="exampleRadios1">
									    <?php echo "{$shipping_rate['name']} - {$shipping_rate['description']} (MMK {$shipping_rate['price']})"; ?>
									  </label>
									
								  </div>
								  <?php endforeach; ?>
							  </div>

							  <div class="form-group">
							  	   <label>Payment Option</label>
							  	   <?php foreach($payment_options as $payment_option): ?>
							  	   <?php 
							  	   	 $checked = ($payment_method == $payment_option['name'])?'checked':'';
							  	   ?>
								  <div class="form-check">							  	  
									  <input class="form-check-input" type="radio" name="payment_method"  value="<?php echo $payment_option['name']; ?>" <?php echo $checked; ?>>
									  <label class="form-check-label" for="exampleRadios1">
									    <?php echo "{$payment_option['name']}"; ?>
									  </label>
									
								  </div>
								  <?php endforeach; ?>
							  </div>

							  

							  <div class="form-group">
							    <label for="customer_name">Customer's Name</label>
							    <input type="text" class="form-control" name="customer_name" value="<?php echo $customer_name; ?>">	
							  </div>

							  <div class="form-group">
							    <label for="customer_phone">Customer's Phone</label>
							    <input type="text" class="form-control" name="customer_phone" value="<?php echo $customer_phone; ?>">	
							  </div>

							  <div class="form-group">
							    <label for="customer_address">Customer's Address</label>
							    <textarea class="form-control"  rows="3" name="customer_address"><?php echo $customer_address; ?></textarea>			   
							  </div>

							  <div class="form-group">
							    <label for="customer_message">Customer's Message</label>
							    <textarea class="form-control"  rows="3" name="customer_message"><?php echo $customer_message; ?></textarea>			   
							  </div>			  
							  
			

							  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
							  
							</form> 
                		

                		</div>
                	</div>
                    
                                       
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
