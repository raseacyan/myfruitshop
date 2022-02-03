<?php

include('inc/connect.php');

$sql = "SELECT * FROM shippings";
$result = $conn->query($sql);

$shipping_rates = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {  	
    array_push($shipping_rates, $row);
  }
} 




$conn->close();

?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Shipping Rates</h1>
                    <a class="btn btn-primary " href="shipping_rates_create.php">Add Shipping Rate</a>
                   
                    <?php if(count($shipping_rates)): ?>                    
                    	<div class="card mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Shipping List
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>                                 
                                            <th>Description</th>
                                            <th>Price</th> 
                                            <th>Action</th>                                 
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>                                 
                                            <th>Description</th>
                                            <th>Price</th> 
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	<?php
                                    		foreach($shipping_rates as $shipping_rate){

                                    			$description = nl2br($shipping_rate['description']);
                                    			
                                    			$html = "<tr>";
                                            	$html .= "<td>{$shipping_rate['name']}</td>";
                                            	$html .= "<td>$description</td>";
                                                $html .= "<td>{$shipping_rate['price']}</td>";
                                                $html .= "<td>";
                                            	$html .= "<a href='shipping_rates_update.php?id={$shipping_rate['id']}'/>Edit</a> | ";
                                            	$html .= "<a href='shipping_rates_delete.php?id={$shipping_rate['id']}'/>Delete</a>";
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