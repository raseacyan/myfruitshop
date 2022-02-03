<?php 
session_start();
include('inc/connect.php');
$payment_method = $_SESSION['payment']['method'];
$payment_amount = $_SESSION['payment']['amount'];
$payment_order_id = $_SESSION['payment']['order_id'];
$payment_invoice_id = $_SESSION['payment']['invoice_id'];

$sql = "SELECT * FROM payment_options WHERE name = '{$payment_method}' ";
$result = $conn->query($sql);

$payment_options = array();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();    
  $payment_description = $row['description'];  
}

if(isset($_POST['submit'])){
    print_r($_POST);
}

?>
<?php include('inc/header.php'); ?>
        <!-- Product section-->
        <section class="py-5">
           
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    
                    <div class="col-md-12">

                  
                        
                        <h1>Your Order is successful</h1>
                        <?php if($payment_method == 'Visa' ): ?>
                            <a href="payment.php" class="btn btn-success">Proceed to payment</a>
                        <?php elseif($payment_method == 'Master'):?>
                            master
                        <?php else: ?>
                            <p>
                                Order Number: <?php echo $payment_order_id; ?> <br>
                                Invoice Number: <?php echo $payment_invoice_id; ?> <br>
                                Amount Payable: <?php echo "MMK {$payment_amount}"; ?> <br>
                                Payment Method: <?php echo $payment_method; ?><br>
                                Payment Instruction: <?php echo $payment_description; ?> <br>
                            </p>
                            
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </section>
        
<?php include('inc/footer.php'); ?>