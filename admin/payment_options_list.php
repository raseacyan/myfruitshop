<?php

include('inc/connect.php');

$sql = "SELECT * FROM payment_options";
$result = $conn->query($sql);

$payment_options = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {  	
    array_push($payment_options, $row);
  }
} 




$conn->close();

?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Payment Options</h1>
                    <a class="btn btn-primary " href="payment_options_create.php">Add Payment Option</a>
                   
                    <?php if(count($payment_options)): ?>                    
                    	<div class="card mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Payment Options List
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>                                 
                                            <th>Description</th>                           
                                            <th>Action</th>                                 
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>                                 
                                            <th>Description</th>                           
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	<?php
                                    		foreach($payment_options as $payment_option){

                                    			$description = nl2br($payment_option['description']);
                                    			
                                    			$html = "<tr>";
                                            	$html .= "<td>{$payment_option['name']}</td>";
                                            	$html .= "<td>$description</td>";
                                                
                                                $html .= "<td>";
                                            	$html .= "<a href='payment_options_update.php?id={$payment_option['id']}'/>Edit</a> | ";
                                            	$html .= "<a href='payment_options_delete.php?id={$payment_option['id']}'/>Delete</a>";
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