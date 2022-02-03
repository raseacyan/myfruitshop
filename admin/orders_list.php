<?php

include('inc/connect.php');

$today = date("Y-m-d");

$sql = "SELECT * FROM orders ORDER BY orders.created_on DESC";
$result = $conn->query($sql);

$orders = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {  	
    array_push($orders, $row);
  }
} 




$conn->close();

?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Order Summary</h1>
                   
                    
                 

                    <?php if(count($orders)): ?>                    
                    	<div class="card mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Orders List
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            
                                            <th>Customer's Name</th>
                                            <th>Order Status</th>
                                            <th>Date</th>                                   <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            
                                            <th>Customer's Name</th>
                                            <th>Order Status</th>
                                            <th>Date</th>                                   <th>Action</th>                        
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	<?php
                                    		foreach($orders as $order){
                                    			
                                                $formattedDate = date("d-m-Y", strtotime($order['created_on']));
                                    			

                                    			$html = "<tr>";                                               
                                            	$html .= "<td>{$order['id']}</td>";
                                                
                                                $html .= "<td>{$order['customer_name']}</td>";
                                                $html .= "<td>{$order['order_status']}</td>";
                                                $html .= "<td>{$formattedDate}</td>";
                                                $html .= "<td>";
                                            	$html .= "<a href='orders_single.php?id={$order['id']}'/>More Details</a>";                                            	
                                            	$html .= "</td>";
                                        		$html .= "</tr>";

                                        		echo $html;
                                    		}

                                    		
                                    	?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else:?>
                    	<p>No records found</p>
                    <?php endif; ?>
                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>