<?php 
session_start();
include('inc/connect.php');
$payment_method = $_SESSION['payment']['method'];
$payment_amount = $_SESSION['payment']['amount'];
$payment_order_id = $_SESSION['payment']['order_id'];
$payment_invoice_id = $_SESSION['payment']['invoice_id'];

if(isset($_POST['submit'])){   


    $url = "http://localhost/myfruitshop/demo_payment_api.php";

    $dataArray = array(
    	'amount'=> $_POST['amount'],
    	'invoice_number' => $_POST['invoice_id'],
        'card_number' => $_POST['card_number'],
        'card_exp_month' => $_POST['card_exp_month'],
        'card_exp_year' => $_POST['card_exp_year'],
        'card_csv' => $_POST['card_csv'],
        'card_holder_name' => $_POST['card_holder_name']
    );

    $queryData = http_build_query($dataArray);

    //create new curl resource
    $ch = curl_init();

    //set the url
    curl_setopt($ch, CURLOPT_URL, $url) ; 
    //request http post
    curl_setopt($ch, CURLOPT_POST, 1) ;
    //add post data
    curl_setopt($ch, CURLOPT_POSTFIELDS, $queryData) ;
    //return the actual result instead of success code
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 

    $api_result = curl_exec($ch);
    $api_result = json_decode($api_result);  

    if($api_result->status == 'success' && $api_result->code == 1){

        //get order id 
        $sql = "SELECT order_id from invoices WHERE id={$api_result->data->invoice_number}";
        $result = $conn->query($sql);    

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();  
          $order_id = $row['order_id'];
        }        

        //update invoice table
        $sql = "UPDATE invoices set amount_received='{$api_result->data->amount}' WHERE id={$api_result->data->invoice_number}";
        if ($conn->query($sql) === TRUE) {  

             $sql = "UPDATE orders set order_status='paid' WHERE id={$order_id}"; 
             if($conn->query($sql) === TRUE){
                $_SESSION['success'] = "Thank you. Your payment is successful";
                unset($_SESSION['payment']);
             }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
             }          
            
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{
         $_SESSION['error'] = "Sorry. Your payment is failed";
    }

    


}
//echo $result->data->email;


//curl_close($ch);//close resource
?>
<?php include('inc/header.php'); ?>
        <!-- Product section-->
        <section class="py-5">

            
           
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    
                    <div class="col-md-12">

                        <?php if(isset($_SESSION['success'])): ?>
                            <div class="alert alert-success" role="alert">
                                    <?php 
                                        echo $_SESSION['success'];
                                        unset($_SESSION['success']);
                                    ?>
                            </div>
                         <?php endif; ?>

                         <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger" role="alert">
                                    <?php 
                                        echo $_SESSION['error'];
                                        unset($_SESSION['error']);
                                    ?>
                            </div>
                         <?php endif; ?>

                        <form method="post" action="payment.php">
                            <div class="form-group">
                            Card Number: <br>
                            <input type="text" name="card_number"/>
                            </div>
                            <div class="form-group">
                            Expiry MM/YY: <br>
                            <input type="text" name="card_exp_month" style="width:50px;"/><input type="text" name="card_exp_year" style="width:50px;"/>
                            </div>
                            <div class="form-group">
                            CSV: <br>
                            <input type="text" name="card_csv" style="width:100px;"/>
                            </div>
                            <div class="form-group mb-2">
                            Card Holder Name <br>
                            <input type="text" name="card_holder_name"/>
                            </div>
                            <input type="hidden" name="amount" value="<?php echo $payment_amount  ?>"/>
                            <input type="hidden" name="invoice_id" value="<?php echo $payment_invoice_id;  ?>"/>
                            <input type="hidden" name="order_id" value="<?php echo $payment_order_id;  ?>"/>
                            <input class="btn btn-primary" type="submit" name="submit" value="Pay Now"/>
                            </form>
                        
                             
                        
                    </div>
                </div>
            </div>
        </section>
        
<?php include('inc/footer.php'); ?>