<?php
include('inc/connect.php');
session_start();

$cart = array();
if(isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'];
}

$sql = "SELECT * FROM shippings WHERE id={$_SESSION['order']['shipping_rate_id']}";
$result = $conn->query($sql);

$shipping_rate = array();

if ($result->num_rows > 0) {
  $shipping_rate = $result->fetch_assoc();     
}else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$order_subtotal = $_SESSION['order']['subtotal'];
$customer_name = $_SESSION['order']['customer_name'];
$customer_phone = $_SESSION['order']['customer_phone'];
$customer_address = $_SESSION['order']['customer_address'];
$customer_message = $_SESSION['order']['customer_message'];
$shipping_cost = $shipping_rate['price'];
$order_total = $order_subtotal + $shipping_cost;
$user_id = $_SESSION['user_id'];
$shipping_rate_id = $_SESSION['order']['shipping_rate_id'];

$payment_method = $_SESSION['order']['payment_method'];

if(isset($_GET['action'])){

    if($_GET['action'] == "cancel"){
        unset($_SESSION['order']);
        header('Location:cart.php');
    }
    
	

	if($_GET['action'] == "save"){

     
	//save to database
    $order_success = false;
	$sql = "INSERT INTO orders (customer_name, customer_phone, customer_address, customer_message, payment_method, user_id, shipping_rate_id) VALUES ('{$customer_name}', '{$customer_phone}','{$customer_address}', '{$customer_message}', '{$payment_method}', '{$user_id}', '{$shipping_rate_id}')";

	if ($conn->query($sql) === TRUE) {
	  $order_id = $conn->insert_id;
	  $_SESSION['payment']['order_id'] = $order_id;
	  $_SESSION['payment']['amount'] = $order_total;
	  $_SESSION['payment']['method'] = $payment_method;
	  unset($_SESSION['order']);
      $order_success = true;	  
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

    if($order_success){

        //
        foreach($cart as $item){
            $sql = "INSERT INTO order_items (quantity, price, product_id, order_id) VALUES ('{$item['quantity']}','{$item['price']}', '{$item['id']}', '{$order_id}')";
            if ($conn->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }


        $sql = "INSERT INTO invoices (order_amount, order_id) VALUES ('{$order_total}','{$order_id}')";

        if ($conn->query($sql) === TRUE) {
            $invoice_id = $conn->insert_id;
            $_SESSION['payment']['invoice_id'] = $invoice_id;
            unset($_SESSION['order']);
            header('Location:order_success.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

   


    }


}


?>

<?php include('inc/header.php'); ?>
        <!-- Product section-->
        <section class="py-5">

           
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    
                    <div class="col-md-12">
                        
                        <h1 class="display-5 fw-bolder">Your Order</h1>
                        <h3>Cart Details</h3>
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
                        <h3>Amount Details</h3>
                        <p>
                        	Subtotal: <?php echo $order_subtotal; ?><br>
                        	Shipping cost: <?php echo $shipping_cost; ?><br>
                        	Order Total: <?php echo $order_total; ?><br>
                        	Selected Payment Method: <?php echo $payment_method; ?>
                        </p>
                        <h3>Customer's Details</h3>
                        <p>
                        	Customer Name: <?php echo $customer_name; ?><br>
                        	Customer Phone: <?php echo $customer_phone; ?><br>
                        	Customer Address: <?php echo $customer_address; ?><br>
                        	
                        </p>
                        <h3>Message to Seller</h3>
                        <p><?php echo $customer_message; ?></p>

                        <a class="btn btn-danger" href="<?php echo "order_confirm.php?action=cancel"; ?>">&#128465; Cancel</a>
                        <a class="btn btn-primary" href="order_create.php">&#9998; Change</a>
                        <a class="btn btn-success" href="<?php echo "order_confirm.php?action=save"; ?>">&#128190; Confirm </a>
                        
                    </div>
                </div>
            </div>
        </section>
        
<?php include('inc/footer.php'); ?>