<?php
include('inc/connect.php');


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$amount_received = '';
	$admin_note = '';
	
	

	$query = "SELECT * FROM invoices WHERE id={$id}";
	$result = $conn->query($query) or die($conn->error);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$amount_received = $row['amount_received'];	
		$admin_note = $row['admin_note']; 	
		
	}else{	
		header('Location:invoice_single.php?id='.$id);
	}
}

if(isset($_POST['submit'])){

	//senitize incoming data
	$id = $conn->real_escape_string(trim($_POST['id']));
	$amount_received = $conn->real_escape_string(trim($_POST['amount_received']));
	$admin_note = $conn->real_escape_string(trim($_POST['admin_note']));

	

	//save to database
	$sql = "UPDATE invoices set amount_received='{$amount_received}', admin_note='{$admin_note}' WHERE id={$id}";

	$amount_received_is_saved = false;
	if ($conn->query($sql) === TRUE) {
	  $amount_received_is_saved = true;	  
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}


	if($amount_received_is_saved){
		$update_order_status = false;

		$sql = "SELECT order_amount, amount_received, order_id from invoices WHERE id={$id}";
		$result = $conn->query($sql);

		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$order_amount = $row['order_amount'];	
			$amount_received = $row['amount_received'];
			$order_id = $row['order_id'];
			if($order_amount == $amount_received){
				$update_order_status = true;
			}				
		}else{	
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	if($update_order_status){
		$sql = "UPDATE orders set order_status='paid' WHERE id={$order_id}";	
		if ($conn->query($sql) === TRUE) {		  
		  header('Location:invoice_single.php?id='.$id);
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}	
	}
}

$conn->close();
?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Update Invoice</h1>

                    
                    
                    <form action="invoice_update.php" method="post" enctype="multipart/form-data">
					  <div class="form-group">
					    
					    <label for="order_status">Amount Received</label>
						 <input type="text" class="form-control" name="amount_received" value="<?php echo $amount_received; ?>">   		   
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
