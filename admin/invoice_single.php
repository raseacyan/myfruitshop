<?php

include('inc/connect.php');



if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT invoices.id, invoices.order_amount, invoices.amount_received, invoices.admin_note, invoices.created_on, orders.id as order_id, orders.customer_name, orders.customer_phone, orders.customer_address, orders.payment_method, orders.created_on as order_datetime, shippings.price as shipping_fee FROM invoices, orders, shippings WHERE invoices.order_id = orders.id AND orders.shipping_rate_id = shippings.id AND invoices.id = {$id}";
    $result = $conn->query($sql);

    $invoice = array();    

    if ($result->num_rows > 0) {       
      $invoice = $result->fetch_assoc();     
    }else{
        echo "Error: ".$conn->error;
    }


    $sql = "SELECT products.image, products.name, order_items.quantity, order_items.price, order_items.quantity * order_items.price as total FROM order_items, products WHERE order_items.product_id = products.id AND order_id = {$invoice['order_id']}";
    $result = $conn->query($sql);

    $order_items = array();

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {    
        array_push($order_items, $row);
      }
    }
}else{
    header('Location:orders_single.php?id='.$invoice['order_id']);
}





$conn->close();

?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">

                   
                    <h1 class="mt-4">Invoice #<?php echo $invoice['id']; ?></h1>
                    <a href="orders_single.php?id=<?php echo $invoice['order_id']; ?>">View Order</a>
                    <div class="card mt-4">                            
                        <div class="card-body">
                            <h2>Invoice Details</h2>
                            <p>
                            Invoice number: <?php echo $invoice['id']; ?><br>        
                            Invoice Date: <?php echo date("d-m-Y", strtotime($invoice['created_on']));?>                   
                            </p>

                            <h2>Order Details</h2>
                            <p>
                            Order number: <?php echo $invoice['order_id']; ?><br>        
                            Order Date: <?php echo date("d-m-Y", strtotime($invoice['order_datetime']));?> <br>
                                        
                            </p>

                            <h3>Order Items</h3>
                            <table class="table">
                            <tr>
                                
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr> 
                            
                            <?php $order_items_total = 0; ?>  
                            <?php foreach($order_items as $item): ?>
                                <?php 
                                    $order_items_total += $item['total'];
                                ?>
                                <tr>
                                    
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['price']; ?></td>
                                    <td><?php echo $item['total']; ?></td>
                                </tr>
                                
                            <?php endforeach; ?>                        
                            </table>

                            

                            <h2>Customer's Details</h2>
                            <p>
                            Customer's Name: <?php echo $invoice['customer_name']; ?><br>
                            Customer's Phone: <?php echo $invoice['customer_phone']; ?><br>
                            Customer's Address: <?php echo $invoice['customer_address']; ?><br>
                            </p>

                            <h2>Payment's Details</h2>
                            <p>
                            SubTotal: <?php echo $order_items_total; ?><br>
                            Shipping Fee: <?php echo $invoice['shipping_fee']; ?><br>
                            Total Amount: <?php echo $invoice['order_amount']; ?><br>
                            Amount Received: <?php echo $invoice['amount_received']; ?><br>
                            Payment Method: <?php echo $invoice['payment_method']; ?><br>
                            Balance: <?php echo $invoice['order_amount'] - $invoice['amount_received'];?>

                            </p>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                             <h2>Additional Details</h2> 
                                                         
                             <p>
                                
                                Admin's Note:<br>                                
                                <?php echo $invoice['admin_note']; ?>
                             </p>
                        </div>
                    </div>
                    <a class="btn btn-primary mt-4" href="invoice_update.php?id=<?php echo $invoice['id']; ?>">Update</a>
                      
                    
                  
                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>