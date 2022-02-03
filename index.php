<?php

include('inc/connect.php');
session_start();

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {    
    array_push($products, $row);
  }
} 
$conn->close();
?>
<?php include('inc/header.php'); ?>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php foreach($products as $product):?>
                
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="<?php echo 'uploads/'.$product['image']; ?>" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?php echo $product['name']; ?></h5>
                                <!-- Product price-->
                                <?php echo 'MMK '. $product['price'].'<br>'; ?>
                                
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=<?php echo $product['id']; ?>">View details</a></div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

            
       
            
        </div>
    </div>
</section>
<?php include('inc/footer.php');?>
