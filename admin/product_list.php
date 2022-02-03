<?php

include('inc/connect.php');

$sql = "SELECT p.id, p.name, p.code, p.price, p.description, p.image, c.name as category FROM products as p, categories as c WHERE p.category_id = c.id";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {  	
    array_push($products, $row);
  }
} 




$conn->close();

?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Products</h1>
                    <a class="btn btn-primary " href="product_create.php">Add Product</a>
                   
                    <?php if(count($products)): ?>                    
                    	<div class="card mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Product List
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Code</th>                                  
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Code</th>                                  
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	<?php
                                    		foreach($products as $product){
                                    			
                                    			$description = nl2br($product['description']);

                                    			$html = "<tr>";
                                            	$html .= "<td>{$product['name']}</td>";
                                                $html .= "<td>{$product['code']}</td>";
                                                $html .= "<td>{$product['price']}</td>";
                                            	$html .= "<td>$description</td>";
                                                $html .= "<td><img src='../uploads/{$product['image']}' width='64'/></td>";
                                                $html .= "<td>{$product['category']}</td>";
                                            	$html .= "<td>";
                                            	$html .= "<a href='product_update.php?id={$product['id']}'/>Edit</a> | ";
                                            	$html .= "<a href='product_delete.php?id={$product['id']}'/>Delete</a>";
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