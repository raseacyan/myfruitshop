<?php

include('inc/connect.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT shippings.price as shipping_fee, invoices.id as invoice_id, orders.id, orders.customer_name, orders.customer_phone, orders.customer_address, orders.payment_method, invoices.order_amount, orders.admin_note, orders.order_status, orders.created_on FROM orders, invoices, shippings WHERE orders.id=invoices.order_id AND orders.shipping_rate_id = shippings.id AND orders.id = {$id}";
    $result = $conn->query($sql);

    $order = array();

    if ($result->num_rows > 0) {
      $order = $result->fetch_assoc();     
    }else{
        echo "Error:".$conn->error;
    }


    $sql = "SELECT products.image, products.name, order_items.quantity, order_items.price, order_items.quantity * order_items.price as total FROM order_items, products WHERE order_items.product_id = products.id AND order_items.order_id = {$id}";
    $result = $conn->query($sql);

    $order_items = array();

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {    
        array_push($order_items, $row);
      }
    } 


}else{
    header('Location:orders_list.php');
}





$conn->close();

?>

<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">


                   
                    <h1 class="mt-4">Order #<?php echo $order['id']; ?></h1>
                    <a href="invoice_single.php?id=<?php echo $order['invoice_id']; ?>">View Invoice</a>
                    <div class="card mt-4">                            
                        <div class="card-body">
                            <h3>Order Items</h3>
                            <table class="table">
                            <tr>
                                <th>Image</th>
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
                                    <td><img src="../uploads/<?php echo $item['image']; ?>" width="50"></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['price']; ?></td>
                                    <td><?php echo $item['total']; ?></td>
                                </tr>
                                
                            <?php endforeach; ?>                        
                            </table>
                            <h3>Order Details</h3>
                            <p>
                            Order number: <?php echo $order['id']; ?><br>                          
                            Order Date: <?php echo date("d-m-Y", strtotime($order['created_on']));?>                   
                            </p>

                            <h3>Customer's Details</h3>
                            <p>
                            Customer's Name: <?php echo $order['customer_name']; ?><br>
                            Customer's Phone: <?php echo $order['customer_phone']; ?><br>
                            Customer's Address: <?php echo $order['customer_address']; ?><br>
                            </p>

                            <h3>Payment's Details</h3>
                            <p>
                            SubTotal: <?php echo $order_items_total; ?><br>                  
                            Shipping Fee: <?php echo $order['shipping_fee']; ?><br>
                            Total Amount: <?php echo $order['order_amount']; ?><br>
                            Payment Method: <?php echo $order['payment_method']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                             <h3>Additional Details</h3> 
                                                     
                             <p>
                                Order Status: <?php echo $order['order_status']; ?><br>
                                Admin's Note:<br>                                
                                <?php echo $order['admin_note']; ?>
                             </p>
                        </div>
                    </div>
                    <a class="btn btn-primary mt-4" href="orders_update.php?id=<?php echo $order['id']; ?>">Update</a>  
                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>