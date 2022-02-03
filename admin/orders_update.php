<?php
include('inc/connect.php');


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$order_status = '';
	$admin_note = '';
	

	$query = "SELECT * FROM orders WHERE id={$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$order_status = $row['order_status'];
		$admin_note= $row['admin_note'];
		
	}else{	
		header('Location:orders_single.php?id='.$id);
	}
}

if(isset($_POST['submit'])){

	//senitize incoming data
	$id = $conn->real_escape_string(trim($_POST['id']));
	$order_status = $conn->real_escape_string(trim($_POST['order_status']));
	$admin_note = $conn->real_escape_string(trim($_POST['admin_note']));

	//save to database
	$sql = "UPDATE orders set order_status='{$order_status}', admin_note='{$admin_note}' WHERE id={$id}";

	if ($conn->query($sql) === TRUE) {
	  header('Location:orders_single.php?id='.$id);
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Update Order</h1>

                    
                    <form action="orders_update.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    
					    <label for="order_status">Order Status</label>
						    <select class="form-control" name="order_status">
						      <option value="pending" <?php echo ($order_status=='pending')?'selected':''; ?>>Pending</option>
						      <option value="paid" <?php echo ($order_status=='paid')?'selected':''; ?>>Paid</option>
						      <option value="shipped" <?php echo ($order_status=='shipped')?'selected':''; ?>>Shipped</option>
						      <option value="completed" <?php echo ($order_status=='completed')?'selected':''; ?>>Completed</option>
						      <option value="cancelled" <?php echo ($order_status=='cancelled')?'selected':''; ?>>Cancelled</option>
						      <option value="refunded" <?php echo ($order_status=='refunded')?'selected':''; ?>>Refunded</option>
						    </select>			   
					  </div>					  
					  <div class="form-group">
					    <label for="admin_note">Admin's Note</label>
					    <textarea class="form-control"  rows="3" name="admin_note"><?php echo $admin_note; ?></textarea>		   
					  </div>
					  
					  
					  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
					  

					  <input type="submit" class="btn btn-primary mt-4" name="submit" value="submit" />
					  
					</form>                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>
